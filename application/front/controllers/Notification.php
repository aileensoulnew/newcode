<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Notification extends MY_Controller {

    public $data;

    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('email_model');
        $this->load->model('freelancer_hire_model');
        $this->lang->load('message', 'english');
//AWS access info start
        $this->load->library('S3');
        //AWS access info end
        include ('include.php');
    }
    public function index() {
        $this->data['title']  = "Notification | Aileensoul";
        $userid = $this->session->userdata('aileenuser');
        $this->load->view('notification/index', $this->data);
    }

    public function recruiter_post($id) {
        $this->data['userid'] = $userid = $this->session->userdata('aileenuser');

        $join_str[0]['table'] = 'recruiter';
        $join_str[0]['join_table_id'] = 'recruiter.user_id';
        $join_str[0]['from_table_id'] = 'rec_post.user_id';
        $join_str[0]['join_type'] = '';

        $data = 'post_id,post_name,post_last_date,post_description,post_skill,post_position,interview_process,min_sal,max_sal,max_year,min_year,fresher,degree_name,industry_type,emp_type,rec_post.created_date,rec_post.user_id,recruiter.rec_firstname,recruiter.re_comp_name,recruiter.rec_lastname,recruiter.recruiter_user_image,recruiter.profile_background,recruiter.re_comp_profile,city,country,post_currency,salary_type';
        $contition_array = array('rec_post.is_delete' => '0', 'rec_post.post_id' => $id);
        $this->data['postdata'] = $this->common->select_data_by_condition('rec_post', $contition_array, $data, $sortby = 'post_id', $orderby = 'desc', $limit = '', $offset = '', $join_str, $groupby = '');


        $this->load->view('notification/rec_post1', $this->data);
    }


    public function rec_profile($id = "") {
        $this->data['userid'] = $userid = $this->session->userdata('aileenuser');
        if ($id == $userid || $id == '') {
            $this->data['recdata'] = $this->common->select_data_by_id('recruiter', 'user_id', $userid, $data = '*', $join_str = array());
        } else {
            $this->data['recdata'] = $this->common->select_data_by_id('recruiter', 'user_id', $id, $data = '*', $join_str = array());
        }
        $this->load->view('notification/rec_profile', $this->data);
    }

    public function rec_post($id) {
        $this->data['userid'] = $userid = $this->session->userdata('aileenuser');
        if ($id == $userid || $id == '') {
            $join_str[0]['table'] = 'recruiter';
            $join_str[0]['join_table_id'] = 'recruiter.user_id';
            $join_str[0]['from_table_id'] = 'rec_post.user_id';
            $join_str[0]['join_type'] = '';

            $contition_array = array('rec_post.user_id' => $userid, 'rec_post.is_delete' => '0');
            $this->data['postdata'] = $this->common->select_data_by_condition('rec_post', $contition_array, $data = 'rec_post.*,recruiter.rec_firstname,recruiter.re_comp_name,recruiter.rec_lastname', $sortby = 'post_id', $orderby = 'desc', $limit = '', $offset = '', $join_str, $groupby = '');
        } else {
            $join_str[0]['table'] = 'recruiter';
            $join_str[0]['join_table_id'] = 'recruiter.user_id';
            $join_str[0]['from_table_id'] = 'rec_post.user_id';
            $join_str[0]['join_type'] = '';

            $contition_array = array('rec_post.user_id' => $id, 'rec_post.is_delete' => '0');
            $this->data['postdata'] = $this->common->select_data_by_condition('rec_post', $contition_array, $data = 'rec_post.*,recruiter.rec_firstname,recruiter.re_comp_name,recruiter.rec_lastname', $sortby = 'post_id', $orderby = 'desc', $limit = '', $offset = '', $join_str, $groupby = '');
        }
        $this->load->view('notification/rec_post', $this->data);
    }

    public function art_post($id) {
        $userid = $this->session->userdata('aileenuser');
        $contition_array = array('user_id' => $userid, 'status' => '1');
        $this->data['artisticdata'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        $contition_array = array('art_post_id' => $id, 'status' => '1', 'is_delete' => '0');
        $this->data['art_data'] = $this->common->select_data_by_condition('art_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        $this->data['get_url'] = $this->get_url($userid);

        $this->data['left_artistic'] = $this->load->view('artist/left_artistic', $this->data, true);
        $this->load->view('notification/art_post', $this->data);
    }

    public function art_post_img($id, $imageid) {
        $userid = $this->session->userdata('aileenuser');
        $contition_array = array('user_id' => $userid, 'status' => '1');
        $this->data['artisticdata'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        $contition_array = array('art_post_id' => $id, 'status' => '1');
        $this->data['art_data'] = $this->common->select_data_by_condition('art_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $contition_array = array('post_id' => $id, 'is_deleted' => '1', 'insert_profile' => '1');
        $artmultiimage = $this->data['artmultiimage'] = $this->common->select_data_by_condition('post_files', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $i = 1;
        foreach ($artmultiimage as $artimg) {
            if ($artimg['post_files_id'] == $imageid) {
                $count = $i;
            }
            $i++;
        }
        $this->data['count'] = $count;
        $contition_array = array('status' => '1', 'is_delete' => '0');
        $artdata = $this->data['results'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = 'art_name,art_lastname,designation,other_skill', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);
        $return_array = array();

        foreach ($artdata as $get) {
            $return = array();
            $return = $get;


            $return['firstname'] = $get['art_name'] . " " . $get['art_lastname'];
            unset($return['art_name']);
            unset($return['art_lastname']);

            array_push($return_array, $return);
        }

        $contition_array = array('status' => '1', 'type' => '2');
        $artpost = $this->data['results'] = $this->common->select_data_by_condition('skill', $contition_array, $data = 'skill', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);
     
        $uni = array_merge($return_array, $artpost);
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
        $this->load->view('notification/art_image', $this->data);
    }

    public function business_post($id) {
        $userid = $this->session->userdata('aileenuser');
        include ('business_include.php');
        $userid = $this->session->userdata('aileenuser');
        $contition_array = array('user_id' => $userid, 'status' => '1');
        $this->data['businessdata'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        $contition_array = array('business_profile_post_id' => $id, 'status' => '1', 'is_delete' => '0');
        $this->data['busienss_data'] = $busienss_data = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        $this->data['business_left'] = $this->load->view('business_profile/business_left', $this->data, true);

        $this->load->view('notification/business_post', $this->data);
    }

    public function bus_post_img($id, $imageid) { 
        $userid = $this->session->userdata('aileenuser');
        include ('business_include.php');
        $contition_array = array('user_id' => $userid, 'status' => '1');
        $this->data['businessdata'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        $contition_array = array('business_profile_post_id' => $id, 'status' => '1');
        $this->data['busienss_data'] = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $contition_array = array('post_id' => $id, 'is_deleted' => '1', 'insert_profile' => '2');
        $busmultiimage = $this->data['busmultiimage'] = $this->common->select_data_by_condition('post_files', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $i = 1;
        foreach ($busmultiimage as $artimg) {
            if ($artimg['post_files_id'] == $imageid) {
                $count = $i;
            }
            $i++;
        }
        $this->data['count'] = $count;

        $contition_array = array('status' => '1', 'business_profile.is_deleted' => '0');
        $businessdata = $this->data['results'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = 'company_name,other_industrial,other_business_type', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        $contition_array = array('status' => '1', 'is_delete' => '0');
        $businesstype = $this->data['results'] = $this->common->select_data_by_condition('business_type', $contition_array, $data = 'business_name', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);
        $contition_array = array('status' => '1', 'is_delete' => '0');
        $industrytype = $this->data['results'] = $this->common->select_data_by_condition('industry_type', $contition_array, $data = 'industry_name', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);
        $unique = array_merge($businessdata, $businesstype, $industrytype);
        foreach ($unique as $key => $value) {
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

        $this->data['demo'] = $result1;
        $this->data['business_left'] = $this->load->view('business_profile/business_left', $this->data, true);
        $this->load->view('notification/bus_image', $this->data);
    }

    public function ajax_business_home_post($post_id) {
        $userid = $this->session->userdata('aileenuser');
        include ('business_include.php');
        $business_login_slug = $this->data['business_login_slug'];
        $user_name = $this->session->userdata('user_name');

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

        $condition_array = array('business_profile_post.business_profile_post_id' => $post_id, 'business_profile_post.is_delete' => '0', 'business_profile_post.status' => '1');
        $join_str[0]['table'] = 'business_profile';
        $join_str[0]['join_table_id'] = 'business_profile.user_id';
        $join_str[0]['from_table_id'] = 'business_profile_post.user_id';
        $join_str[0]['join_type'] = '';
        $data = "business_profile.business_user_image,business_profile.company_name,business_profile.industriyal,business_profile.business_slug,business_profile.other_industrial,business_profile.business_slug,business_profile_post.business_profile_post_id,business_profile_post.product_name,business_profile_post.product_description,business_profile_post.business_likes_count,business_profile_post.business_like_user,business_profile_post.created_date,business_profile_post.posted_user_id,business_profile.user_id";
        $business_profile_post = $this->common->select_data_by_condition('business_profile_post', $condition_array, $data, $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str, $groupby = '');

        $return_html = '';
        $row = $business_profile_post[0];

        $post_business_user_image = $row['business_user_image'];
        $post_company_name = $row['company_name'];
        $post_business_profile_post_id = $row['business_profile_post_id'];
        $post_product_name = $row['product_name'];
        $post_product_image = $row['product_image'];
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

        if ($row) {


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

                    if (!file_exists($this->config->item('bus_profile_thumb_upload_path') . $posted_business_user_image)) {
                        $return_html .= '<img src = "' . base_url(NOBUSIMAGE) . '" alt = "noimage">';
                    } else {
                        $return_html .= '<img src = "' . BUS_PROFILE_THUMB_UPLOAD_URL . $posted_business_user_image . '" name = "image_src" id = "image_src" alt = "'. $posted_business_user_image .'"/>';
                    }
                    $return_html .= '</a>';
                } else {
                    $return_html .= '<a href = "' . base_url('business-profile/dashboard/' . $posted_business_slug) . '">';
                    $return_html .= '<img src = "' . base_url(NOBUSIMAGE) . '" alt = "No Image">';
                    $return_html .= '</a>';
                }
            } else {
                if ($post_business_user_image) {
                    $return_html .= '<a href = "' . base_url('business-profile/dashboard/' . $post_business_slug) . '">';
                    if (!file_exists($this->config->item('bus_profile_thumb_upload_path') . $post_business_user_image)) {
                        $return_html .= '<img src = "' . base_url(NOBUSIMAGE) . '" alt = "No Image">';
                    } else {
                        $return_html .= '<img src = "' . BUS_PROFILE_THUMB_UPLOAD_URL . $post_business_user_image . '" alt = "No Image">';
                    }
                    $return_html .= '</a>';
                } else {
                    $return_html .= '<a href = "' . base_url('business-profile/dashboard/' . $post_business_slug) . '">';
                    $return_html .= '<img src = "' . base_url(NOBUSIMAGE) . '" alt = "No Image">';
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
<span role = "presentation" aria-hidden = "true"> · </span> <span class = "ctre_date">
' . $this->common->time_elapsed_string(date('Y-m-d H:i:s', strtotime($post_created_date))) . '
</span> </div></div>
</li>';
            } else {
                $return_html .= '<li>
                            <div class = "post-design-product">
                                <a class = "post_dot" href = "' . base_url('business-profile/dashboard/' . $post_business_slug) . '" title = "' . ucfirst(strtolower($post_company_name)) . '">
' . ucfirst(strtolower($post_company_name)) . '</a>
                    <span role = "presentation" aria-hidden = "true"> · </span>
<div class = "datespan"> <span class = "ctre_date" >
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
<div class = "dropdown1">
<a onClick = "myFunction(' . $post_business_profile_post_id . ')" class = "dropbtn_common  dropbtn1 fa fa-ellipsis-v">
</a>
<div id = "myDropdown' . $post_business_profile_post_id . '" class = "dropdown-content1 dropdown2_content">';

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
                //$allowed = VALID_IMAGE;
                $allowespdf = array('pdf');
                $allowesvideo = array('mp4', 'webm', 'qt', 'mov', 'MP4');
                $allowesaudio = array('mp3');
                $filename = $businessmultiimage[0]['file_name'];
                $ext = pathinfo($filename, PATHINFO_EXTENSION);
                if (in_array($ext, $allowed)) {

                    $return_html .= '<div class = "one-image">';

                    $return_html .= '<a href = "' . base_url('business-profile/post-detail/' . $business_login_slug . '/' . $post_business_profile_post_id) . '">
<img src = "' . BUS_POST_MAIN_UPLOAD_URL . $businessmultiimage[0]['file_name'] . '" alt="'. $businessmultiimage[0]['file_name'] . '">
</a>
</div>';
                } elseif (in_array($ext, $allowespdf)) {

                    $return_html .= '<div>
<a title = "click to open" href = "' . BUS_POST_MAIN_UPLOAD_URL . $businessmultiimage[0]['file_name'] . '"><div class = "pdf_img">
    <embed src="' . BUS_POST_MAIN_UPLOAD_URL . $businessmultiimage[0]['file_name'] . '" width="100%" height="450px" />
</div>
</a>
</div>';
                } elseif (in_array($ext, $allowesvideo)) {

                    $return_html .= '<div>
<video width = "100%" height = "350" id="show_video' . $businessmultiimage[0]['post_files_id'] . '" onplay="playtime(' . $businessmultiimage[0]['post_files_id'] . ',' . $post_business_profile_post_id . ')" onClick="count_videouser(' . $businessmultiimage[0]['post_files_id'] . ',' . $post_business_profile_post_id . ');" controls>
<source src = "' . BUS_POST_MAIN_UPLOAD_URL . $businessmultiimage[0]['file_name'] . '" type = "video/mp4">
<source src = "' . BUS_POST_MAIN_UPLOAD_URL . $businessmultiimage[0]['file_name'] . '" type = "video/ogg">
Your browser does not support the video tag.
</video>
</div>';
                } elseif (in_array($ext, $allowesaudio)) {

                    $return_html .= '<div class = "audio_main_div">
<div class = "audio_img">
<img src = "' . base_url('assets/images/music-icon.png') . '" alt="music icon">
</div>
<div class = "audio_source">
<audio id = "audio_player" width = "100%" height = "100" controls>
<source src = "' . BUS_POST_MAIN_UPLOAD_URL . $businessmultiimage[0]['file_name'] . '" type = "audio/mp3">
<source src = "movie.ogg" type = "audio/ogg">
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
<img class = "two-columns" src = "' . BUS_POST_RESIZE1_UPLOAD_URL . $multiimage['file_name'] . '" alt="'. $multiimage['file_name'] .'">
</a>
</div>';
                }
            } elseif (count($businessmultiimage) == 3) {

                $return_html .= '<div class = "three-image-top" >
<a href = "' . base_url('business-profile/post-detail/' . $business_login_slug . '/' . $post_business_profile_post_id) . '">
<img class = "three-columns" src = "' . BUS_POST_RESIZE4_UPLOAD_URL . $businessmultiimage[0]['file_name'] . '" alt="'. $businessmultiimage[0]['file_name'] .'">
</a>
</div>
<div class = "three-image" >

<a href = "' . base_url('business-profile/post-detail/' . $business_login_slug . '/' . $post_business_profile_post_id) . '" alt="'.$business_login_slug.'">
<img class = "three-columns" src = "' . BUS_POST_RESIZE1_UPLOAD_URL . $businessmultiimage[1]['file_name'] . '" alt="'.$businessmultiimage[1]['file_name'].'">
</a>
</div>
<div class = "three-image" >
<a href = "' . base_url('business-profile/post-detail/' . $business_login_slug . '/' . $post_business_profile_post_id) . '">
<img class = "three-columns" src = "' . BUS_POST_RESIZE1_UPLOAD_URL . $businessmultiimage[2]['file_name'] . '" alt="'.$businessmultiimage[2]['file_name'].'">
</a>
</div>';
            } elseif (count($businessmultiimage) == 4) {

                foreach ($businessmultiimage as $multiimage) {

                    $return_html .= '<div class = "four-image">
<a href = "' . base_url('business-profile/post-detail/' . $business_login_slug . '/' . $post_business_profile_post_id) . '">
<img class = "breakpoint" src = "' . BUS_POST_RESIZE2_UPLOAD_URL . $multiimage['file_name'] . '" alt="'.$multiimage['file_name'].'">
</a>
</div>';
                }
            } elseif (count($businessmultiimage) > 4) {

                $i = 0;
                foreach ($businessmultiimage as $multiimage) {

                    $return_html .= '<div class = "four-image">
<a href = "' . base_url('business-profile/post-detail/' . $business_login_slug . '/' . $post_business_profile_post_id) . '">
<img src = "' . BUS_POST_RESIZE2_UPLOAD_URL . $multiimage['file_name'] . '" alt="'.$multiimage['file_name'].'">
</a>
</div>';

                    $i++;
                    if ($i == 3)
                        break;
                }

                $return_html .= '<div class = "four-image">
<a href = "' . base_url('business-profile/post-detail/' . $business_login_slug . '/' . $post_business_profile_post_id) . '">
<img src = "' . BUS_POST_RESIZE2_UPLOAD_URL . $businessmultiimage[3]['file_name'] . '" alt="'.$businessmultiimage[3]['file_name'].'">
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

            $contition_array = array('business_profile_post_id' => $post_business_profile_post_id, 'status' => '1', 'is_delete' => '0');
            $commnetcount = $this->common->select_data_by_condition('business_profile_post_comment', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

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


                $return_html .= '<a href = "javascript:void(0);" onclick = "likeuserlist(' . $post_business_profile_post_id . ')">';
                $return_html .= '<div class = "like_one_other">';

               
                $business_fname1 = $this->db->get_where('business_profile', array('user_id' => $likelistarray[0], 'status' => '1'))->row()->company_name;

                if (in_array($userid, $likelistarray)) {
                    $return_html .= "You";
                    $return_html .= "&nbsp;";
                } else {
                    $return_html .= ucfirst(strtolower($business_fname1));
                    $return_html .= "&nbsp;";
                }
                if (count($likelistarray) > 1) {
                    $return_html .= " and ";

                    $return_html .= $countlike;
                    $return_html .= "&nbsp;";
                    $return_html .= "others";
                }
                $return_html .= '</div>
</a>
</div>';
            }

            $return_html .= '<div class = "likeusername' . $post_business_profile_post_id . '" id = "likeusername' . $post_business_profile_post_id . '" style = "display:none">';

            $likeuser = $post_business_like_user;
            $countlike = $post_business_likes_count - 1;
            $likelistarray = explode(', ', $likeuser);

            $return_html .= '<a href = "javascript:void(0);" onclick = "likeuserlist(' . $post_business_profile_post_id . ')">';

            $likeuser = $post_business_like_user;
            $countlike = $post_business_likes_count - 1;
            $likelistarray = explode(', ', $likeuser);

            $business_fname1 = $this->db->get_where('business_profile', array('user_id' => $value, 'status' => '1'))->row()->company_name;

            $return_html .= '<div class = "like_one_other">';

            $return_html .= ucfirst(strtolower($business_fname1));
            $return_html .= "&nbsp;";

            if (count($likelistarray) > 1) {

                $return_html .= "and";

                $return_html .= $countlike;
                $return_html .= "&nbsp;";
                $return_html .= "others";
            }
            $return_html .= '</div>
</a>
</div>

<div class = "art-all-comment col-md-12">
<div id = "fourcomment' . $post_business_profile_post_id . '" style = "display:none;">
</div>
<div id = "threecomment' . $post_business_profile_post_id . '" style = "display:block">
<div class = "insertcomment' . $post_business_profile_post_id . '">';

            $contition_array = array('business_profile_post_id' => $post_business_profile_post_id, 'status' => '1');
            $businessprofiledata = $this->data['businessprofiledata'] = $this->common->select_data_by_condition('business_profile_post_comment', $contition_array, $data = '*', $sortby = 'business_profile_post_comment_id', $orderby = 'DESC', $limit = '1', $offset = '', $join_str = array(), $groupby = '');
            if ($businessprofiledata) {
                foreach ($businessprofiledata as $rowdata) {
                    $companyname = $this->db->get_where('business_profile', array('user_id' => $rowdata['user_id']))->row()->company_name;

                    $slugname1 = $this->db->get_where('business_profile', array('user_id' => $rowdata['user_id'], 'status' => '1'))->row()->business_slug;

                    $return_html .= '<div class = "all-comment-comment-box">
<div class = "post-design-pro-comment-img">';
                    $business_userimage = $this->db->get_where('business_profile', array('user_id' => $rowdata['user_id'], 'status' => '1'))->row()->business_user_image;

                    if ($business_userimage) {
                        $return_html .= '<a href = "' . base_url('business-profile/dashboard/' . $slugname1) . '">';

                        if (!file_exists($this->config->item('bus_profile_thumb_upload_path') . $business_userimage)) {

                            $return_html .= '<img src = "' . base_url(NOBUSIMAGE) . '" alt = "noimage">';
                        } else {
                            $return_html .= '<img src = "' . BUS_PROFILE_THUMB_UPLOAD_URL . $business_userimage . '" alt = "'.$business_userimage.'">';
                        }
                        $return_html .= '</a>';
                    } else {
                        $return_html .= '<a href = "' . base_url('business-profile/dashboard/' . $slugname1) . '">';

                        $return_html .= '<img src = "' . base_url(NOBUSIMAGE) . '" alt = "noimage"></a>';
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
<div contenteditable = "true" class = "editable_text editav_2" name = "' . $rowdata['business_profile_post_comment_id'] . '" id = "editcomment' . $rowdata['business_profile_post_comment_id'] . '" placeholder = "Enter Your Comment " value = "" onkeyup = "commentedit(' . $rowdata['business_profile_post_comment_id'] . ')" onpaste = "OnPaste_StripFormatting(this, event);">' . $rowdata['comments'] . '</div>
<span class = "comment-edit-button"><button id = "editsubmit' . $rowdata['business_profile_post_comment_id'] . '" style = "display:none" onClick = "edit_comment(' . $rowdata['business_profile_post_comment_id'] . ')">Save</button></span>
</div>
</div>
<div class = "art-comment-menu-design">
<div class = "comment-details-menu" id = "likecomment1' . $rowdata['business_profile_post_comment_id'] . '">
<a id = "' . $rowdata['business_profile_post_comment_id'] . '" onClick = "comment_like1(this.id)">';

                    $userid = $this->session->userdata('aileenuser');
                    $contition_array = array('business_profile_post_comment_id' => $rowdata['business_profile_post_comment_id'], 'status' => '1');
                    $businesscommentlike = $this->data['businesscommentlike'] = $this->common->select_data_by_condition('business_profile_post_comment', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
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

                if (!file_exists($this->config->item('bus_profile_thumb_upload_path') . $business_userimage)) {


                    $return_html .= '<img src = "' . base_url(NOBUSIMAGE) . '" alt = "noimage">';
                } else {
                    $return_html .= '<img src = "' . BUS_PROFILE_THUMB_UPLOAD_URL . $business_userimage . '" alt = "'.$business_userimage.'">';
                }
            } else {


                $return_html .= '<img src = "' . base_url(NOBUSIMAGE) . '" alt = "noimage">';
            }
            $return_html .= '</div>

<div id = "content" class = "col-md-12  inputtype-comment cmy_2" >
<div contenteditable = "true" class = "edt_2 editable_text" name = "' . $post_business_profile_post_id . '" id = "post_comment' . $post_business_profile_post_id . '" placeholder = "Add a Comment ..." onClick = "entercomment(' . $post_business_profile_post_id . ')" onpaste = "OnPaste_StripFormatting(this, event);"></div>
<div class="mob-comment">       
                            <button id="' . $post_business_profile_post_id . '" onClick="insert_comment(this.id)"><img src="' . base_url('assets/img/send.png') . '" alt="senimage">
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
        } else {

            $return_html = '<div class="art_no_post_avl"><h3>Post</h3><div class="art-img-nn"><div class="art_no_post_img"><img src=' . base_url('assets/img/bui-no.png') . ' alt="noimage"></div><div class="art_no_post_text">Sorry,this content is not available at the moment.</div></div></div>';
            $this->data['no_business_contact_html'] = '<div class="art-img-nn"><div class="art_no_post_img"><img src="' . base_url('assets/img/No_Contact_Request.png') . '" alt="no contact available"></div><div class="art_no_post_text">No Contacts Available.</div></div>';
        }

        echo $return_html;       
    }

    //business _profile notification post end 

    public function select_req() {
        $userid = $this->session->userdata('aileenuser');

        $contition_array = array('not_read' => '2', 'not_to_id' => $userid);
        $result = $this->common->select_data_by_condition('notification', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $count = count($result);
        echo $count;
    }

    public function update_req() {
        $userid = $this->session->userdata('aileenuser');

        $contition_array = array('not_read' => '2', 'not_to_id' => $userid);
        $result = $this->common->select_data_by_condition('notification', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $data = array(
            'not_read' => '1'
        );
    
        foreach ($result as $cnt) {
            $updatedata = $this->common->update_data($data, 'notification', 'not_id', $cnt['not_id']);
        }

        $count = count($updatedata);
        echo $count;
    }

    public function recnot($id = " ") {
        $userid = $this->session->userdata('aileenuser');

        $contition_array = array('not_read' => '2', 'not_to_id' => $userid);
        $result = $this->common->select_data_by_condition('notification', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $data = array(
            'not_read' => '1'
        );
    
        foreach ($result as $cnt) {
            $updatedata = $this->common->update_data($data, 'notification', 'not_id', $cnt['not_id']);
        }

        $count = count($updatedata);
        echo $count;
    }
    public function select_notification($to_id = '') { 
        $to_id = $this->db->select('user_id')->get_where('business_profile', array('business_profile_id' => $to_id))->row()->user_id;


        $userid = $this->session->userdata('aileenuser');
        $contition_array = array('not_read' => '2', 'not_to_id' => $to_id, 'not_type !=' => '1', 'not_type !=' => '2');
        $result = $this->common->select_data_by_condition('notification', $contition_array, $data = 'count(*) as total', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        $count = $result[0]['total']; 
        echo json_encode(array('count' => $count, 'to_id' => $to_id));
    }

    public function select_notification1() { 
        $userid = $this->session->userdata('aileenuser');
        $contition_array = array('not_read' => '2', 'not_to_id' => $userid, 'not_type !=' => '1', 'not_type !=' => '2');
        $result = $this->common->select_data_by_condition('notification', $contition_array, $data = 'count(*) as total', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $count = $result[0]['total'];
        echo $count;
    }

    public function update_notification() {
        $userid = $this->session->userdata('aileenuser');

        $contition_array = array('not_read' => '2', 'not_to_id' => $userid, 'not_type !=' => '1', 'not_type !=' => '2');
        $result = $this->common->select_data_by_condition('notification', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $data = array(
            'not_read' => '1'
        );

        foreach ($result as $cnt) {
            $updatedata = $this->common->update_data($data, 'notification', 'not_id', $cnt['not_id']);
        }

        $count = count($updatedata);
        echo $count;
    }

//Notification count select & update for apply,save,like,comment,contact and follow End
//Notification count select & update for Message start
    public function select_msg_noti($not_from = '') {
        $userid = $this->session->userdata('aileenuser');
        $contition_array = array('not_read' => '2', 'not_to_id' => $userid, 'not_type' => '2', 'not_from' => $not_from);
        $result = $this->common->select_data_by_condition('notification', $contition_array, $data = 'COUNT(*) as total', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = 'not_from_id');
        $count = $result[0]['total'];
        echo $count;
    }

    public function update_msg_noti($not_from = '') {
        $userid = $this->session->userdata('aileenuser');


        $contition_array = array('not_read' => '2', 'not_to_id' => $userid, 'not_type' => '2', 'not_from' => $not_from);
        $result = $this->common->select_data_by_condition('notification', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        $data = array(
            'not_read' => '1'
        );
        foreach ($result as $cnt) {
            $updatedata = $this->common->update_data($data, 'notification', 'not_id', $cnt['not_id']);
        }

        $count = count($updatedata);
        echo $count;
    }

//Notification count select & update for Message End

    public function freelancer_hire_post($id) {

        $userid = $this->session->userdata('aileenuser');

        $contition_array = array('is_delete' => '0', 'post_id' => $id, 'status' => '1');

        $postdata = $this->data['freelancerpostdata'] = $this->common->select_data_by_condition('freelancer_post', $contition_array, $data, $sortby = 'freelancer_post.created_date', $orderby = 'desc', $limit = '', $offset = '', $join_str, $groupby = '');
   
        $this->load->view('notification/freelancer_hire_post', $this->data);
    }

    public function not_header($id = "") {
        $userid = $this->session->userdata('aileenuser');
        // freelancer hire shortlisted  notification start
        $contition_array = array('notification.not_type' => '9', 'notification.not_from' => '5', 'notification.not_to_id' => $userid, 'created_date BETWEEN DATE_SUB(NOW(), INTERVAL 2 MONTH) AND NOW()');
        $join_str = array(array(
                'join_type' => '',
                'table' => 'save',
                'join_table_id' => 'notification.not_product_id',
                'from_table_id' => 'save.save_id'),
            array(
                'join_type' => '',
                'table' => 'freelancer_hire_reg',
                'join_table_id' => 'notification.not_from_id',
                'from_table_id' => 'freelancer_hire_reg.user_id')
        );
        $data = array('notification.*', ' save.*', 'freelancer_hire_reg.user_id as user_id', 'freelancer_hire_reg.fullname as first_name', 'freelancer_hire_reg.freelancer_hire_user_image as user_image', 'freelancer_hire_reg.username as last_name');
        $shortlist = $this->data['shortlist'] = $work_post = $this->common->select_data_by_condition('notification', $contition_array, $data, $sortby = 'save_id', $orderby = 'desc', $limit = '', $offset = '', $join_str, $groupby = '');
        // freelancer hire shortlisted notification end

        $userid = $this->session->userdata('aileenuser');
        $contition_array = array('notification.not_type' => '3', 'notification.not_to_id' => $userid, 'notification.not_from' => '2', 'created_date BETWEEN DATE_SUB(NOW(), INTERVAL 2 MONTH) AND NOW()');
        $join_str = array(array(
                'join_type' => '',
                'table' => 'job_apply',
                'join_table_id' => 'notification.not_product_id',
                'from_table_id' => 'job_apply.app_id'),
            array(
                'join_type' => '',
                'table' => 'job_reg',
                'join_table_id' => 'notification.not_from_id',
                'from_table_id' => 'job_reg.user_id')
        );
        $data = array('notification.*', 'job_apply.*', 'job_reg.user_id as user_id', 'job_reg.fname as first_name', 'job_reg.job_user_image as user_image', 'job_reg.lname as last_name');
        $rec_not = $this->data['rec_not'] = $this->common->select_data_by_condition('notification', $contition_array, $data, $sortby = 'app_id', $orderby = 'desc', $limit = '', $offset = '', $join_str, $groupby = '');
// recruiter notification end
// job notfication start 

        $contition_array = array('notification.not_type' => '4', 'notification.not_to_id' => $userid, 'notification.not_from' => '1', 'created_date BETWEEN DATE_SUB(NOW(), INTERVAL 2 MONTH) AND NOW()');
        $join_str = array(array(
                'join_type' => '',
                'table' => 'user_invite',
                'join_table_id' => 'notification.not_product_id',
                'from_table_id' => 'user_invite.invite_id'),
            array(
                'join_type' => '',
                'table' => 'recruiter',
                'join_table_id' => 'notification.not_from_id',
                'from_table_id' => 'recruiter.user_id')
        );
        $data = array('notification.*', ' user_invite.*', ' recruiter.user_id as user_id', 'recruiter.rec_firstname as first_name', 'recruiter.recruiter_user_image as user_image', 'recruiter.rec_lastname as last_name');

        $job_not = $this->data['job_not'] = $this->common->select_data_by_condition('notification', $contition_array, $data, $sortby = 'invite_id', $orderby = 'desc', $limit = '', $offset = '', $join_str, $groupby = '');

// job notification end
// freelancer hire  notification start
        $contition_array = array('notification.not_type' => '3', 'notification.not_from' => '4', 'notification.not_to_id' => $userid, 'created_date BETWEEN DATE_SUB(NOW(), INTERVAL 2 MONTH) AND NOW()');

        $join_str = array(
            array(
                'join_type' => '',
                'table' => 'freelancer_apply',
                'join_table_id' => 'notification.not_product_id',
                'from_table_id' => 'freelancer_apply.app_id'),
            array(
                'join_type' => '',
                'table' => 'freelancer_post_reg',
                'join_table_id' => 'notification.not_from_id',
                'from_table_id' => 'freelancer_post_reg.user_id')
        );
        $data = array('notification.*', 'freelancer_apply.*', ' freelancer_post_reg.user_id as user_id', 'freelancer_post_reg.freelancer_post_fullname as first_name', 'freelancer_post_reg.freelancer_post_user_image as user_image', 'freelancer_post_reg.freelancer_post_username as last_name');

        $hire_not = $this->data['hire_not'] = $this->common->select_data_by_condition('notification', $contition_array, $data, $sortby = 'app_id', $orderby = 'desc', $limit = '', $offset = '', $join_str, $groupby = '');
        // freelancer hire notification end
// freelancer post notification start
    
        $contition_array = array('notification.not_type' => '4', 'notification.not_from' => '5', 'notification.not_to_id' => $userid, 'created_date BETWEEN DATE_SUB(NOW(), INTERVAL 2 MONTH) AND NOW()');
        $join_str = array(array(
                'join_type' => '',
                'table' => 'user_invite',
                'join_table_id' => 'notification.not_product_id',
                'from_table_id' => 'user_invite.invite_id'),
            array(
                'join_type' => '',
                'table' => 'freelancer_hire_reg',
                'join_table_id' => 'notification.not_from_id',
                'from_table_id' => 'freelancer_hire_reg.user_id')
        );
        $data = array('notification.*', ' user_invite.*', 'freelancer_hire_reg.user_id as user_id', 'freelancer_hire_reg.fullname as first_name', 'freelancer_hire_reg.freelancer_hire_user_image as user_image', 'freelancer_hire_reg.username as last_name');

        $work_post = $this->data['work_post'] = $work_post = $this->common->select_data_by_condition('notification', $contition_array, $data, $sortby = 'invite_id', $orderby = 'desc', $limit = '', $offset = '', $join_str, $groupby = '');

// freelancer post notification end
//artistic notification start
// follow notification start

        $contition_array = array('notification.not_type' => '8', 'notification.not_from' => '3', 'notification.not_to_id' => $userid, 'created_date BETWEEN DATE_SUB(NOW(), INTERVAL 2 MONTH) AND NOW()');
        $join_str = array(array(
                'join_type' => '',
                'table' => 'follow',
                'join_table_id' => 'notification.not_product_id',
                'from_table_id' => 'follow.follow_id'),
            array(
                'join_type' => '',
                'table' => 'art_reg',
                'join_table_id' => 'notification.not_from_id',
                'from_table_id' => 'art_reg.user_id')
        );
        $data = array('notification.*', ' follow.*', ' art_reg.user_id as user_id', 'art_reg.art_name as first_name', 'art_reg.art_user_image as user_image', 'art_reg.art_lastname as last_name', 'art_reg.slug as slug');

        $artfollow = $this->data['artfollow'] = $this->common->select_data_by_condition('notification', $contition_array, $data, $sortby = 'follow_id', $orderby = 'desc', $limit = '', $offset = '', $join_str, $groupby = '');

// follow notification end
//post comment notification start

        $contition_array = array('notification.not_type' => '6', 'not_img' => '1', 'notification.not_from' => 3, 'notification.not_to_id' => $userid, 'created_date BETWEEN DATE_SUB(NOW(), INTERVAL 2 MONTH) AND NOW()');
        $join_str = array(array(
                'join_type' => '',
                'table' => 'artistic_post_comment',
                'join_table_id' => 'notification.not_product_id',
                'from_table_id' => 'artistic_post_comment.artistic_post_comment_id'),
            array(
                'join_type' => '',
                'table' => 'art_reg',
                'join_table_id' => 'notification.not_from_id',
                'from_table_id' => 'art_reg.user_id')
        );
        $data = array('notification.*', ' artistic_post_comment.*', ' art_reg.user_id as user_id', 'art_reg.art_name as first_name', 'art_reg.art_user_image as user_image', 'art_reg.art_lastname as last_name');
        $artcommnet = $this->data['artcommnet'] = $this->common->select_data_by_condition('notification', $contition_array, $data, $sortby = 'artistic_post_comment_id', $orderby = 'desc', $limit = '', $offset = '', $join_str, $groupby = '');
// comment notification end
//post like notification start
        $contition_array = array('notification.not_type' => '5', 'notification.not_from' => '3', 'not_img' => '2', 'notification.not_to_id' => $userid, 'created_date BETWEEN DATE_SUB(NOW(), INTERVAL 2 MONTH) AND NOW()');
        $join_str = array(array(
                'join_type' => '',
                'table' => 'art_post',
                'join_table_id' => 'notification.not_product_id',
                'from_table_id' => 'art_post.art_post_id'),
            array(
                'join_type' => '',
                'table' => 'art_reg',
                'join_table_id' => 'notification.not_from_id',
                'from_table_id' => 'art_reg.user_id')
        );
        $data = array('notification.*', ' art_post.*', ' art_reg.user_id as user_id', 'art_reg.art_name as first_name', 'art_reg.art_user_image as user_image', 'art_reg.art_lastname as last_name');
        $artlike = $this->data['artlike'] = $this->common->select_data_by_condition('notification', $contition_array, $data, $sortby = 'art_post_id', $orderby = 'desc', $limit = '', $offset = '', $join_str, $groupby = '');

        $contition_array = array('notification.not_type' => '5', 'not_img' => '5', 'notification.not_from' => '3', 'notification.not_to_id' => $userid, 'created_date BETWEEN DATE_SUB(NOW(), INTERVAL 2 MONTH) AND NOW()');
        $join_str = array(array(
                'join_type' => '',
                'table' => 'post_files',
                'join_table_id' => 'notification.not_product_id',
                'from_table_id' => 'post_files.post_files_id'),
            array(
                'join_type' => '',
                'table' => 'art_reg',
                'join_table_id' => 'notification.not_from_id',
                'from_table_id' => 'art_reg.user_id')
        );
        $data = array('notification.*', ' post_files.*', ' art_reg.user_id as user_id', 'art_reg.art_name as first_name', 'art_reg.art_user_image as user_image', 'art_reg.art_lastname as last_name');
        $artimglike = $this->data['artimglike'] = $this->common->select_data_by_condition('notification', $contition_array, $data, $sortby = 'post_files_id', $orderby = 'desc', $limit = '', $offset = '', $join_str, $groupby = '');


        $contition_array = array('notification.not_type' => '5', 'not_img' => '3', 'notification.not_from' => '3', 'notification.not_to_id' => $userid, 'created_date BETWEEN DATE_SUB(NOW(), INTERVAL 2 MONTH) AND NOW()');
        $join_str = array(array(
                'join_type' => '',
                'table' => 'artistic_post_comment',
                'join_table_id' => 'notification.not_product_id',
                'from_table_id' => 'artistic_post_comment.artistic_post_comment_id'),
            array(
                'join_type' => '',
                'table' => 'art_reg',
                'join_table_id' => 'notification.not_from_id',
                'from_table_id' => 'art_reg.user_id')
        );
        $data = array('notification.*', ' artistic_post_comment.*', ' art_reg.user_id as user_id', 'art_reg.art_name as first_name', 'art_reg.art_user_image as user_image', 'art_reg.art_lastname as last_name');
        $artcmtlike = $this->data['artcmtlike'] = $this->common->select_data_by_condition('notification', $contition_array, $data, $sortby = 'artistic_post_comment_id', $orderby = 'desc', $limit = '', $offset = '', $join_str, $groupby = '');

        $contition_array = array('notification.not_type' => '6', 'not_img' => '4', 'notification.not_from' => '3', 'notification.not_to_id' => $userid, 'created_date BETWEEN DATE_SUB(NOW(), INTERVAL 2 MONTH) AND NOW()');
        $join_str = array(array(
                'join_type' => '',
                'table' => 'art_post_image_comment',
                'join_table_id' => 'notification.not_product_id',
                'from_table_id' => 'art_post_image_comment.post_image_comment_id'),
            array(
                'join_type' => '',
                'table' => 'art_reg',
                'join_table_id' => 'notification.not_from_id',
                'from_table_id' => 'art_reg.user_id')
        );
        $data = array('notification.*', ' art_post_image_comment.*', ' art_reg.user_id as user_id', 'art_reg.art_name as first_name', 'art_reg.art_user_image as user_image', 'art_reg.art_lastname as last_name');
        $artimgcommnet = $this->data['artimgcommnet'] = $this->common->select_data_by_condition('notification', $contition_array, $data, $sortby = 'post_image_comment_id', $orderby = 'desc', $limit = '', $offset = '', $join_str, $groupby = '');

        $contition_array = array('notification.not_type' => '5', 'not_img' => '6', 'notification.not_from' => '3', 'notification.not_to_id' => $userid, 'created_date BETWEEN DATE_SUB(NOW(), INTERVAL 2 MONTH) AND NOW()');
        $join_str = array(array(
                'join_type' => '',
                'table' => 'art_post_image_comment',
                'join_table_id' => 'notification.not_product_id',
                'from_table_id' => 'art_post_image_comment.post_image_comment_id'),
            array(
                'join_type' => '',
                'table' => 'art_reg',
                'join_table_id' => 'notification.not_from_id',
                'from_table_id' => 'art_reg.user_id')
        );
        $data = array('notification.*', ' art_post_image_comment.*', ' art_reg.user_id as user_id', 'art_reg.art_name as first_name', 'art_reg.art_user_image as user_image', 'art_reg.art_lastname as last_name');
        $this->data['artimgcmtlike'] = $artimgcmtlike = $this->common->select_data_by_condition('notification', $contition_array, $data, $sortby = 'post_image_comment_id', $orderby = 'desc', $limit = '', $offset = '', $join_str, $groupby = '');

// like notification end
// artistic notification end
// business profile notification start
// follow notification start

        $contition_array = array('notification.not_type' => '8', 'notification.not_from' => '6', 'notification.not_to_id' => $userid, 'created_date BETWEEN DATE_SUB(NOW(), INTERVAL 2 MONTH) AND NOW()');
        $join_str = array(array(
                'join_type' => '',
                'table' => 'follow',
                'join_table_id' => 'notification.not_product_id',
                'from_table_id' => 'follow.follow_id'),
            array(
                'join_type' => '',
                'table' => 'business_profile',
                'join_table_id' => 'notification.not_from_id',
                'from_table_id' => 'business_profile.user_id')
        );
        $data = array('notification.*', 'follow.*', 'business_profile.user_id as user_id', 'business_profile.company_name as first_name', 'business_profile.business_user_image as user_image');

        $busifollow = $this->data['busifollow'] = $this->common->select_data_by_condition('notification', $contition_array, $data, $sortby = 'follow_id', $orderby = 'desc', $limit = '', $offset = '', $join_str, $groupby = '');

// follow notification end
// comment notification start

        $contition_array = array('notification.not_type' => '6', 'not_img' => '1', 'notification.not_from' => '6', 'notification.not_to_id' => $userid, 'created_date BETWEEN DATE_SUB(NOW(), INTERVAL 2 MONTH) AND NOW()');
        $join_str = array(array(
                'join_type' => '',
                'table' => 'business_profile_post_comment',
                'join_table_id' => 'notification.not_product_id',
                'from_table_id' => 'business_profile_post_comment.business_profile_post_comment_id'),
            array(
                'join_type' => '',
                'table' => 'business_profile',
                'join_table_id' => 'notification.not_from_id',
                'from_table_id' => 'business_profile.user_id')
        );
        $data = array('notification.*', 'business_profile_post_comment.*', 'business_profile.user_id as user_id', 'business_profile.company_name as first_name', 'business_profile.business_user_image as user_image');

        $buscommnet = $this->data['buscommnet'] = $this->common->select_data_by_condition('notification', $contition_array, $data, $sortby = 'business_profile_post_comment_id', $orderby = 'desc', $limit = '', $offset = '', $join_str, $groupby = '');
        $contition_array = array('notification.not_type' => '6', 'not_img' => '4', 'notification.not_from' => '6', 'notification.not_to_id' => $userid, 'created_date BETWEEN DATE_SUB(NOW(), INTERVAL 2 MONTH) AND NOW()');
        $join_str = array(array(
                'join_type' => '',
                'table' => 'bus_post_image_comment',
                'join_table_id' => 'notification.not_product_id',
                'from_table_id' => 'bus_post_image_comment.post_image_comment_id'),
            array(
                'join_type' => '',
                'table' => 'business_profile',
                'join_table_id' => 'notification.not_from_id',
                'from_table_id' => 'business_profile.user_id')
        );
        $data = array('notification.*', 'bus_post_image_comment.*', 'business_profile.user_id as user_id', 'business_profile.company_name as first_name', 'business_profile.business_user_image as user_image');

        $this->data['busimgcommnet'] = $busimgcommnet = $this->common->select_data_by_condition('notification', $contition_array, $data, $sortby = 'post_image_comment_id', $orderby = 'desc', $limit = '', $offset = '', $join_str, $groupby = '');

// comment notification end
// like notification start
        $contition_array = array('notification.not_type' => '5', 'not_img' => '2', 'notification.not_from' => '6', 'notification.not_to_id' => $userid, 'created_date BETWEEN DATE_SUB(NOW(), INTERVAL 2 MONTH) AND NOW()');
        $join_str = array(array(
                'join_type' => '',
                'table' => 'business_profile_post',
                'join_table_id' => 'notification.not_product_id',
                'from_table_id' => 'business_profile_post.business_profile_post_id'),
            array(
                'join_type' => '',
                'table' => 'business_profile',
                'join_table_id' => 'notification.not_from_id',
                'from_table_id' => 'business_profile.user_id')
        );
        $data = array('notification.*', 'business_profile_post.*', 'business_profile.user_id as user_id', 'business_profile.company_name as first_name', 'business_profile.business_user_image as user_image');

        $buslike = $this->data['buslike'] = $this->common->select_data_by_condition('notification', $contition_array, $data, $sortby = 'business_profile_post_id', $orderby = 'desc', $limit = '', $offset = '', $join_str, $groupby = '');

        $contition_array = array('notification.not_type' => '5', 'not_img' => '3', 'notification.not_from' => '6', 'notification.not_to_id' => $userid, 'created_date BETWEEN DATE_SUB(NOW(), INTERVAL 2 MONTH) AND NOW()');
        $join_str = array(array(
                'join_type' => '',
                'table' => 'business_profile_post_comment',
                'join_table_id' => 'notification.not_product_id',
                'from_table_id' => 'business_profile_post_comment.business_profile_post_comment_id'),
            array(
                'join_type' => '',
                'table' => 'business_profile',
                'join_table_id' => 'notification.not_from_id',
                'from_table_id' => 'business_profile.user_id')
        );
        $data = array('notification.*', 'business_profile_post_comment.*', 'business_profile.user_id as user_id', 'business_profile.company_name as first_name', 'business_profile.business_user_image as user_image');

        $buscmtlike = $this->data['buscmtlike'] = $this->common->select_data_by_condition('notification', $contition_array, $data, $sortby = 'business_profile_post_comment_id', $orderby = 'desc', $limit = '', $offset = '', $join_str, $groupby = '');

        $contition_array = array('notification.not_type' => '5', 'not_img' => '5', 'notification.not_from' => '6', 'notification.not_to_id' => $userid, 'created_date BETWEEN DATE_SUB(NOW(), INTERVAL 2 MONTH) AND NOW()');
        $join_str = array(array(
                'join_type' => '',
                'table' => 'post_files',
                'join_table_id' => 'notification.not_product_id',
                'from_table_id' => 'post_files.post_files_id'),
            array(
                'join_type' => '',
                'table' => 'business_profile',
                'join_table_id' => 'notification.not_from_id',
                'from_table_id' => 'business_profile.user_id')
        );
        $data = array('notification.*', 'post_files.*', 'business_profile.user_id as user_id', 'business_profile.company_name as first_name', 'business_profile.business_user_image as user_image');

        $busimglike = $this->data['busimglike'] = $this->common->select_data_by_condition('notification', $contition_array, $data, $sortby = 'post_files_id', $orderby = 'desc', $limit = '', $offset = '', $join_str, $groupby = '');

        $contition_array = array('notification.not_type' => '5', 'not_img' => '6', 'notification.not_from' => '6', 'notification.not_to_id' => $userid, 'created_date BETWEEN DATE_SUB(NOW(), INTERVAL 2 MONTH) AND NOW()');
        $join_str = array(array(
                'join_type' => '',
                'table' => 'bus_post_image_comment',
                'join_table_id' => 'notification.not_product_id',
                'from_table_id' => 'bus_post_image_comment.post_image_comment_id'),
            array(
                'join_type' => '',
                'table' => 'business_profile',
                'join_table_id' => 'notification.not_from_id',
                'from_table_id' => 'business_profile.user_id')
        );
        $data = array('notification.*', 'bus_post_image_comment.*', 'business_profile.user_id as user_id', 'business_profile.company_name as first_name', 'business_profile.business_user_image as user_image');

        $busimgcmtlike = $this->data['busimgcmtlike'] = $this->common->select_data_by_condition('notification', $contition_array, $data, $sortby = 'post_image_comment_id', $orderby = 'desc', $limit = '', $offset = '', $join_str, $groupby = '');

        $this->data['totalnotifi'] = $totalnotifi = array_merge((array) $rec_not, (array) $job_not, (array) $hire_not, (array) $work_post, (array) $artcommnet, (array) $artlike, (array) $artcmtlike, (array) $artimglike, (array) $artimgcommnet, (array) $artfollow, (array) $artimgcmtlike, (array) $busimgcommnet, (array) $busifollow, (array) $buscommnet, (array) $buslike, (array) $buscmtlike, (array) $busimgcmtlike, (array) $busimglike, (array) $shortlist);
        $this->data['totalnotification'] = $totalnotification = $this->aasort($totalnotifi, "not_created_date");
        $i = 0;
        foreach ($totalnotification as $total) {
   


            if ($total['not_from'] == 1) {
                $companyname = $this->db->get_where('recruiter', array('user_id' => $total['user_id']))->row()->re_comp_name;

                $notification .= '<li class="';
                if ($total['not_active'] == 1) {
                    $notification .= 'active2';
                }
                $notification .= '"';
                $notification .= '><a href="' . base_url('notification/recruiter_post/' . $total['post_id']) . '" onClick="not_active(' . $total['not_id'] . ')"><div class="notification-database">';
                $notification .= '<div class="notification-pic">';


                $filename = $this->config->item('rec_profile_thumb_upload_path') . $total['user_image'];
                $s3 = new S3(awsAccessKey, awsSecretKey);
                $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                if ($total['user_image'] != '' && $info) {
                    $notification .= '<img src="' . REC_PROFILE_THUMB_UPLOAD_URL . $total['user_image'] . '" alt="'.$total['user_image'].'">';
                } else {
                    $a = $total['first_name'];
                    $b = $total['last_name'];
                    $acr = substr($a, 0, 1);
                    $bcr = substr($b, 0, 1);


                    $notification .= '<div class="post-img-div">';
                    $notification .= '' . ucwords($acr) . ucwords($bcr) . '';
                    $notification .= '</div>';
                }

                $notification .= '</div><div class="notification-data-inside">';
                $notification .= '<h6><font color="black"><b><i> Recruiter</i></font></b><b>' . '  ' . ucwords($total['first_name']) . ' ' . ucwords($total['last_name']) . '</b>  <span class="noti-msg-y"> From ' . ucwords($companyname) . '  Invited you for an interview. </span></h6>';
                $notification .= '<div ><i class="clockimg" ></i><span class="day-text">';
                $notification .= '' . $this->common->time_elapsed_string($total['not_created_date'], $full = false) . '';
                $notification .= '</span></div></div></div></a></li>';
            }
            
            if ($total['not_from'] == 3 && $total['not_img'] == 0) {

                $notification .= '<li class="';
                if ($total['not_active'] == 1) {
                    $notification .= 'active2';
                }
                $notification .= '"';

                $geturl = $this->get_url($total['user_id']);

                $notification .= '><a href="' . base_url('artist/details/' . $geturl) . '" onClick="not_active(' . $total['not_id'] . ')"><div class="notification-database">';
                $notification .= '<div class="notification-pic">';


                $filename = $this->config->item('art_profile_thumb_upload_path') . $total['user_image'];
                $s3 = new S3(awsAccessKey, awsSecretKey);
                $filepath = $s3->getObjectInfo(bucket, $filename);

                if ($total['user_image'] && $filepath) {
                    $notification .= '<img src="' . ART_PROFILE_THUMB_UPLOAD_URL . $total['user_image'] . '" alt="'.$total['user_image'].'">';
                } else {
                    $notification .= '<img src = "' . base_url(NOARTIMAGE) . '" alt = "noimage">';
                }

                $notification .= '</div><div class="notification-data-inside">';
                $notification .= '<h6><b>' . '  ' . ucfirst(strtolower($total['first_name'])) . ' ' . ucfirst(strtolower($total['last_name'])) . '</b> <span class="noti-msg-y"> Started following you in artistic profile.</span></h6>';
                $notification .= '<div ><i class="clockimg" ></i><span class="day-text">';
                $notification .= '' . $this->common->time_elapsed_string($total['not_created_date'], $full = false) . '';
                $notification .= '</span></div></div></div></a></li>';
            }
            
            $art_not_from = $total['not_from'];
            $art_not_img = $total['not_img'];
            if ($art_not_from == '3' && $art_not_img == '1') {

                $notification .= '<li class="';
                if ($total['not_active'] == 1) {
                    $notification .= 'active2';
                }
                $notification .= '"';
                $notification .= '><a href="' . base_url('notification/art-post/' . $total['art_post_id']) . '" onClick="not_active(' . $total['not_id'] . ')"><div class="notification-database">';
                $notification .= '<div class="notification-pic">';

                $filename = $this->config->item('art_profile_thumb_upload_path') . $total['user_image'];
                $s3 = new S3(awsAccessKey, awsSecretKey);
                $filepath = $s3->getObjectInfo(bucket, $filename);

              
                if ($total['user_image'] && $filepath) {
                    $notification .= '<img src="' . ART_PROFILE_THUMB_UPLOAD_URL . $total['user_image'] . '" alt="'.$total['user_image'].'">';
                } else {
                    $notification .= '<img src = "' . base_url(NOARTIMAGE) . '" alt = "noartimage">';
                }
                $notification .= '</div><div class="notification-data-inside">';
                
                $notification .= '<h6>';
                $notification .= '<b>' . ' ' . ucwords($total['first_name']) . ' ' . ucwords($total['last_name']) . '</b><span class="noti-msg-y"> Commneted on your post in artistic profile.</span>';
                $notification .= '</h6><div><i class="clockimg" ></i><span class="day-text">';
                $notification .= '' . $this->common->time_elapsed_string($total['not_created_date'], $full = false) . '';
                $notification .= '</span></div></div></div></a></li>';
            }
            

            $art_not_from = $total['not_from'];
            $art_not_img = $total['not_img'];
            if ($art_not_from == '3' && $art_not_img == '2') {

                $notification .= '<li class="';
                if ($total['not_active'] == 1) {
                    $notification .= 'active2';
                }
                $notification .= '"';
                $notification .= '><a href="' . base_url('notification/art-post/' . $total['art_post_id']) . '" onClick="not_active(' . $total['not_id'] . ')"><div class="notification-database">';
                $notification .= '<div class="notification-pic">';


                $filename = $this->config->item('art_profile_thumb_upload_path') . $total['user_image'];
                $s3 = new S3(awsAccessKey, awsSecretKey);
                $filepath = $s3->getObjectInfo(bucket, $filename);


             
                if ($total['user_image'] && $filepath) {
                    $notification .= '<img src="' . ART_PROFILE_THUMB_UPLOAD_URL . $total['user_image'] . '" alt="'.$total['user_image'].'">';
                } else {
                    $notification .= '<img src = "' . base_url(NOARTIMAGE) . '" alt = "noimage">';
                }

                $notification .= '</div><div class="notification-data-inside">';
                $notification .= '<h6><b>' . '  ' . ucwords($total['first_name']) . ' ' . ucwords($total['last_name']) . '</b> <span class="noti-msg-y">Likes your post in artistic profile.</sapn></h6>';
                $notification .= '<div ><i class="clockimg" ></i><span class="day-text">';
                $notification .= '' . $this->common->time_elapsed_string($total['not_created_date'], $full = false) . '';
                $notification .= '</span></div></div> </div></a> </li>';
            }

        
            if ($total['not_from'] == 3) {
                if ($total['not_img'] == 3) {

                    $notification .= '<li class="';
                    if ($total['not_active'] == 1) {
                        $notification .= 'active2';
                    }
                    $notification .= '"';
                    $notification .= '><a href="' . base_url('notification/art-post/' . $total['art_post_id']) . '" onClick="not_active(' . $total['not_id'] . ')"><div class="notification-database"><div class="notification-pic" >';

                    $filename = $this->config->item('art_profile_thumb_upload_path') . $total['user_image'];
                    $s3 = new S3(awsAccessKey, awsSecretKey);
                    $filepath = $s3->getObjectInfo(bucket, $filename);

              
                    if ($total['user_image'] && $filepath) {
                        $notification .= '<img src="' . ART_PROFILE_THUMB_UPLOAD_URL . $total['user_image'] . '" alt="'.$total['user_image'].'">';
                    } else {
                        $notification .= '<img src = "' . base_url(NOARTIMAGE) . '" alt = "noimage">';
                    }
                    $notification .= '</div>';
                    $notification .= '<div class="notification-data-inside">';
                    $notification .= '<h6><b>' . ucwords($total['first_name']) . ' ' . ucwords($total['last_name']) . '</b> <span class="noti-msg-y"> Likes your post`s comment in artistic profile.</h6>';
                    $notification .= '<div ><i class="clockimg" ></i><span class="day-text">';
                    $notification .= '' . $this->common->time_elapsed_string($total['not_created_date'], $full = false) . '';
                    $notification .= '</span></div>';
                    $notification .= '</div></div></a>';
                    $notification .= '</li>';
                }
            }
            //6
            if ($total['not_from'] == 3) {
                if ($total['not_img'] == 5) {
                    $notification .= '<li class="';
                    if ($total['not_active'] == 1) {
                        $notification .= 'active2';
                    }
                    $notification .= '"';
                    $notification .= '><a href="' . base_url('notification/art_post_img/' . $total['post_id'] . '/' . $total['post_files_id']) . '"><div class="notification-database"><div class="notification-pic">';

                    $filename = $this->config->item('art_profile_thumb_upload_path') . $total['user_image'];
                    $s3 = new S3(awsAccessKey, awsSecretKey);
                    $filepath = $s3->getObjectInfo(bucket, $filename);

                
                    if ($total['user_image'] && $filepath) {
                        $notification .= '<img src="' . ART_PROFILE_THUMB_UPLOAD_URL . $total['user_image'] . '" alt="'.$total['user_image'].'">';
                    } else {
                        $notification .= '<img src = "' . base_url(NOARTIMAGE) . '" alt = "noimage">';
                    }
                    $notification .= '</div>';
                    $notification .= '<div class="notification-data-inside">';
                    $notification .= '<h6><b>' . ucwords($total['first_name']) . ' ' . ucwords($total['last_name']) . '</b> <span class="noti-msg-y"> Likes your photo in artistic profile. </sapn></h6>';
                    $notification .= '<div ><i class="clockimg" ></i><span class="day-text">';
                    $notification .= '' . $this->common->time_elapsed_string($total['not_created_date'], $full = false) . '';
                    $notification .= '</span></div></div>';
                    $notification .= '</div></a>';
                    $notification .= '</li>';
                }
            }
            //7
            if ($total['not_from'] == 3) {
                if ($total['not_img'] == 4) {
                    $postid = $this->db->get_where('post_files', array('post_files_id' => $total['post_image_id']))->row()->post_id;
                    $notification .= '<li class="';
                    if ($total['not_active'] == 1) {
                        $notification .= 'active2';
                    }
                    $notification .= '"';
                    $notification .= '><a href="' . base_url('notification/art_post_img/' . $postid . '/' . $total['post_image_id']) . '" onClick="not_active(' . $total['not_id'] . ')"><div class="notification-database"><div class="notification-pic">';

                    $filename = $this->config->item('art_profile_thumb_upload_path') . $total['user_image'];
                    $s3 = new S3(awsAccessKey, awsSecretKey);
                    $filepath = $s3->getObjectInfo(bucket, $filename);

                   
                    if ($total['user_image'] && $filepath) {
                        $notification .= '<img src="' . ART_PROFILE_THUMB_UPLOAD_URL . $total['user_image'] . '" alt="'.$total['user_image'].'">';
                    } else {
                        $notification .= '<img src = "' . base_url(NOARTIMAGE) . '" alt = "noimage">';
                    }
                    $notification .= '</div>';
                    $notification .= '<div class="notification-data-inside">';
                    $notification .= '<h6><b>' . ucwords($total['first_name']) . ' ' . ucwords($total['last_name']) . '</b> <span class="noti-msg-y">Commented on your photo in artistic profile.</sapn></h6>';
                    $notification .= '<div ><i class="clockimg" ></i><span class="day-text">';
                    $notification .= '' . $this->common->time_elapsed_string($total['not_created_date'], $full = false) . '';
                    $notification .= '</span></div> </div>';
                    $notification .= '</div></a>';
                    $notification .= '</li>';
                }
            }
            //8
            if ($total['not_from'] == 3) {
                if ($total['not_img'] == 6) {
                    $postid = $this->db->get_where('post_files', array('post_files_id' => $total['post_image_id']))->row()->post_id;
                    $notification .= '<li class="';
                    if ($total['not_active'] == 1) {
                        $notification .= 'active2';
                    }
                    $notification .= '"';
                    $notification .= '><a href="' . base_url('notification/art_post_img/' . $postid . '/' . $total['post_image_id']) . '" onClick="not_active(' . $total['not_id'] . ')"><div class="notification-database"><div class="notification-pic" >';

                    $filename = $this->config->item('art_profile_thumb_upload_path') . $total['user_image'];
                    $s3 = new S3(awsAccessKey, awsSecretKey);
                    $filepath = $s3->getObjectInfo(bucket, $filename);


                   
                    if ($total['user_image'] && $filepath) {
                        $notification .= '<img src="' . ART_PROFILE_THUMB_UPLOAD_URL . $total['user_image'] . '" alt="'.$total['user_image'].'" >';
                    } else {
                        $notification .= '<img src = "' . base_url(NOARTIMAGE) . '" alt = "noimage">';
                    }
                    $notification .= '</div>';
                    $notification .= '<div class="notification-data-inside">';
                    $notification .= '<h6><b>' . ucwords($total['first_name']) . ' ' . ucwords($total['last_name']) . '</b> <span class="noti-msg-y">Likes your photo`s comment in artistic profile.</h6>';
                    $notification .= '<div ><i class="clockimg" ></i><span class="day-text">';
                    $notification .= '' . $this->common->time_elapsed_string($total['not_created_date'], $full = false) . '';
                    $notification .= '</span></div></div>';
                    $notification .= '</div></a>';
                    $notification .= '</li>';
                }
            }
            //9
            $bus_not_from = $total['not_from'];
            $bus_not_img = $total['not_img'];
            $companyname = $this->db->get_where('business_profile', array('user_id' => $total['not_from_id']))->row()->company_name;
            if ($bus_not_from == '6' && $bus_not_img == '1') {
                $notification .= '<li class="';
                if ($total['not_active'] == 1) {
                    $notification .= 'active2';
                }
                $notification .= '"';
                $notification .= '><a href="' . base_url('notification/business-profile-post/' . $total['business_profile_post_id']) . '" onClick="not_active(' . $total['not_id'] . ')"><div class="notification-database">';
                $notification .= '<div class="notification-pic">';
                $filename = $this->config->item('bus_profile_thumb_upload_path') . $total['user_image'];
                    $s3 = new S3(awsAccessKey, awsSecretKey);
                    $filepath = $s3->getObjectInfo(bucket, $filename);


                 
                    if ($total['user_image'] && $filepath) {
                        $notification .= '<img src="' . BUS_PROFILE_THUMB_UPLOAD_URL . $total['user_image'] . '" alt="'.$total['user_image'].'">';
                } else {

                    $notification .= '<img src = "' . base_url(NOBUSIMAGE2) . '" alt = "No Business Image">';
                }
                $notification .= '</div><div class="notification-data-inside">';
                $notification .= '<h6><b>' . '  ' . ucwords($companyname) . '</b><span class="noti-msg-y"> Commented on your post in business profile. </span></h6>';
                $notification .= '<div ><i class="clockimg" ></i><span class="day-text">';
                $notification .= '' . $this->common->time_elapsed_string($total['not_created_date'], $full = false) . '';
                $notification .= '</span></div></div> </div></a> </li>';
            }
            //10
            if ($total['not_from'] == 6 && $total['not_img'] == 0) {
                $busslug = $this->db->get_where('business_profile', array('user_id' => $total['user_id']))->row()->business_slug;
                $companyname = $this->db->get_where('business_profile', array('user_id' => $total['not_from_id']))->row()->company_name;
                $notification .= '<li class="';
                if ($total['not_active'] == 1) {
                    $notification .= 'active2';
                }
                $notification .= '"';
                $notification .= '><a href="' . base_url('business-profile/details/' . $busslug) . '" onClick="not_active(' . $total['not_id'] . ')"><div class="notification-database">';
                $notification .= '<div class="notification-pic">';

                $filename = $this->config->item('bus_profile_thumb_upload_path') . $total['user_image'];
                    $s3 = new S3(awsAccessKey, awsSecretKey);
                    $filepath = $s3->getObjectInfo(bucket, $filename);


                    if ($total['user_image'] && $filepath) {
                        $notification .= '<img src="' . BUS_PROFILE_THUMB_UPLOAD_URL . $total['user_image'] . '" alt="'.$total['user_image'].'">';
                } else {


                    $notification .= '<img src = "' . base_url(NOBUSIMAGE2) . '" alt = "No Business Image">';
                }
                $notification .= '</div><div class="notification-data-inside">';
                $notification .= '<h6><b>' . '  ' . ucwords($companyname) . '</b> <span class="noti-msg-y">Started following you in business profile.</span></h6>';
                $notification .= '<div ><i class="clockimg" ></i><span class="day-text">';
                $notification .= '' . $this->common->time_elapsed_string($total['not_created_date'], $full = false) . '';
                $notification .= '</span></div></div> </div></a> </li>';
            }
            //11
            $bus_not_from = $total['not_from'];
            $bus_not_img = $total['not_img'];
            $companyname = $this->db->get_where('business_profile', array('user_id' => $total['not_from_id']))->row()->company_name;
            if ($bus_not_from == '6' && $bus_not_img == '2') {
                $notification .= '<li class="';
                if ($total['not_active'] == 1) {
                    $notification .= 'active2';
                }
                $notification .= '"';
                $notification .= '><a href="' . base_url('notification/business-profile-post/' . $total['business_profile_post_id']) . '" onClick="not_active(' . $total['not_id'] . ')"><div class="notification-database">';
                $notification .= '<div class="notification-pic">';
                $filename = $this->config->item('bus_profile_thumb_upload_path') . $total['user_image'];
                    $s3 = new S3(awsAccessKey, awsSecretKey);
                    $filepath = $s3->getObjectInfo(bucket, $filename);


                    if ($total['user_image'] && $filepath) {
                        $notification .= '<img src="' . BUS_PROFILE_THUMB_UPLOAD_URL . $total['user_image'] . '" alt="'.$total['user_image'].'">';
                } else {


                    $notification .= '<img src = "' . base_url(NOBUSIMAGE2) . '" alt = "No Business Image">';
                }
                $notification .= '</div><div class="notification-data-inside">';
                $notification .= '<h6><b>' . '  ' . ucwords($companyname) . '</b> <span class="noti-msg-y"> Likes your post in business profile. </span> </h6>';
                $notification .= '<div ><i class="clockimg" ></i><span class="day-text">';
                $notification .= '' . $this->common->time_elapsed_string($total['not_created_date'], $full = false) . '';
                $notification .= '</span></div></div> </div> </a></li>';
            }
            //12
            if ($total['not_from'] == 6) {
                if ($total['not_img'] == 3) {
                    $companyname = $this->db->get_where('business_profile', array('user_id' => $total['not_from_id']))->row()->company_name;
                    $notification .= '<li class="';
                    if ($total['not_active'] == 1) {
                        $notification .= 'active2';
                    }
                    $notification .= '"';
                    $notification .= '><a href="' . base_url('notification/business-profile-post/' . $total['business_profile_post_id']) . '" onClick="not_active(' . $total['not_id'] . ')">
                    <div class="notification-database"> <div class="notification-pic" >';

                   $filename = $this->config->item('bus_profile_thumb_upload_path') . $total['user_image'];
                    $s3 = new S3(awsAccessKey, awsSecretKey);
                    $filepath = $s3->getObjectInfo(bucket, $filename);


                
                    if ($total['user_image'] && $filepath) {
                        $notification .= '<img src="' . BUS_PROFILE_THUMB_UPLOAD_URL . $total['user_image'] . '" alt="'.$total['user_image'].'">';
                    } else {

                        $notification .= '<img src = "' . base_url(NOBUSIMAGE2) . '" alt = "No Business Image">';
                    }
                    $notification .= '</div>';
                    $notification .= '<div class="notification-data-inside">';
                    $notification .= '<h6><b>' . ucwords($companyname) . '</b> <span class="noti-msg-y"> Likes your post`s comment in business profile.</h6>';
                    $notification .= '<div ><i class="clockimg" ></i><span class="day-text">';
                    $notification .= '' . $this->common->time_elapsed_string($total['not_created_date'], $full = false) . '';
                    $notification .= '</span></div> </div>';
                    $notification .= '</div></a>';
                    $notification .= '</li>';
                }
            }
            //13
            if ($total['not_from'] == 6) {
                if ($total['not_img'] == 5) {
                    $companyname = $this->db->get_where('business_profile', array('user_id' => $total['not_from_id']))->row()->company_name;
                    $notification .= '<li class="';
                    if ($total['not_active'] == 1) {
                        $notification .= 'active2';
                    }
                    $notification .= '"';
                    $notification .= '><a href="' . base_url('notification/business-profile-post-detail/' . $total['post_id'] . '/' . $total['post_files_id']) . '" onClick="not_active(' . $total['not_id'] . ')"><div class="notification-database"><div class="notification-pic" >';
                    $filename = $this->config->item('bus_profile_thumb_upload_path') . $total['user_image'];
                    $s3 = new S3(awsAccessKey, awsSecretKey);
                    $filepath = $s3->getObjectInfo(bucket, $filename);


                  
                    if ($total['user_image'] && $filepath) {
                        $notification .= '<img src="' . BUS_PROFILE_THUMB_UPLOAD_URL . $total['user_image'] . '" alt="'.$total['user_image'].'">';
                    } else {

                        $notification .= '<img src = "' . base_url(NOBUSIMAGE2) . '" alt = "No Business Image">';
                    }
                    $notification .= '</div>';
                    $notification .= '<div class="notification-data-inside">';
                    $notification .= '<h6><b>' . ucwords($companyname) . '</b> <span class="noti-msg-y"> Likes your photo in business profile. </span></h6>';
                    $notification .= '<div ><i class="clockimg" ></i><span class="day-text">';
                    $notification .= '' . $this->common->time_elapsed_string($total['not_created_date'], $full = false) . '';
                    $notification .= '</span></div></div>';
                    $notification .= '</div></a>';
                    $notification .= '</li>';
                }
            }
            //14
            if ($total['not_from'] == 6) {
                if ($total['not_img'] == 4) {
                    $companyname = $this->db->get_where('business_profile', array('user_id' => $total['not_from_id']))->row()->company_name;
                    $postid = $this->db->get_where('post_files', array('post_files_id' => $total['post_image_id']))->row()->post_id;
                    $notification .= '<li class="';
                    if ($total['not_active'] == 1) {
                        $notification .= 'active2';
                    }
                    $notification .= '"';
                    $notification .= '><a href="' . base_url('notification/business-profile-post-detail/' . $postid . '/' . $total['post_image_id']) . '" onClick="not_active(' . $total['not_id'] . ')"><div class="notification-database"><div class="notification-pic" >';
                    $filename = $this->config->item('bus_profile_thumb_upload_path') . $total['user_image'];
                    $s3 = new S3(awsAccessKey, awsSecretKey);
                    $filepath = $s3->getObjectInfo(bucket, $filename);


                  
                    if ($total['user_image'] && $filepath) {
                        $notification .= '<img src="' . BUS_PROFILE_THUMB_UPLOAD_URL . $total['user_image'] . '" alt="'.$total['user_image'].'">';
                    } else {

                        $notification .= '<img src = "' . base_url(NOBUSIMAGE2) . '" alt = "No Business Image">';
                    }
                    $notification .= '</div>';
                    $notification .= '<div class="notification-data-inside">';
                    $notification .= '<h6><b>' . ucwords($companyname) . '</b> <span class="noti-msg-y"> Commented on your photo in business profile. </span></h6>';
                    $notification .= '<div ><i class="clockimg" ></i><span class="day-text">';
                    $notification .= '' . $this->common->time_elapsed_string($total['not_created_date'], $full = false) . '';
                    $notification .= '</span></div></div>';
                    $notification .= '</div></a>';
                    $notification .= '</li>';
                }
            }
            //15
            if ($total['not_from'] == 6) {
                if ($total['not_img'] == 6) {
                    $companyname = $this->db->get_where('business_profile', array('user_id' => $total['not_from_id']))->row()->company_name;
                    $postid = $this->db->get_where('post_files', array('post_files_id' => $total['post_image_id']))->row()->post_id;
                    $notification .= '<li class="';
                    if ($total['not_active'] == 1) {
                        $notification .= 'active2';
                    }
                    $notification .= '"';
                    $notification .= '><a href="' . base_url('notification/business-profile-post-detail/' . $postid . '/' . $total['post_image_id']) . '" onClick="not_active(' . $total['not_id'] . ')"><div class="notification-database"><div class="notification-pic" >';
                    $filename = $this->config->item('bus_profile_thumb_upload_path') . $total['user_image'];
                    $s3 = new S3(awsAccessKey, awsSecretKey);
                    $filepath = $s3->getObjectInfo(bucket, $filename);


                   
                    if ($total['user_image'] && $filepath) {
                        $notification .= '<img src="' . BUS_PROFILE_THUMB_UPLOAD_URL . $total['user_image'] . '" alt="'.$total['user_image'].'">';
                    } else {

                        $notification .= '<img src = "' . base_url(NOBUSIMAGE2) . '" alt = "No Business Image">';
                    }
                    $notification .= '</div>';
                    $notification .= '<div class="notification-data-inside">';
                    $notification .= '<h6><b>' . ucwords($companyname) . '</b> <span class="noti-msg-y"> Likes your photos comment in business profile.</h6>';
                    $notification .= '<div ><i class="clockimg" ></i><span class="day-text">';
                    $notification .= '' . $this->common->time_elapsed_string($total['not_created_date'], $full = false) . '';
                    $notification .= '</span></div> </div>';
                    $notification .= '</div></a>';
                    $notification .= '</li>';
                }
            }
            //16
            if ($total['not_from'] == 2) {
                $job_slug = $this->db->get_where('job_reg', array('user_id' => $total['not_from_id']))->row()->slug;
                $notification .= '<li class="';
                if ($total['not_active'] == 1) {
                    $notification .= 'active2';
                }
                $notification .= '"';
                $notification .= '><a href="' . base_url('job/resume/' . $job_slug . '?page=recruiter') . '" onClick="not_active(' . $total['not_id'] . ')"><div class="notification-database">';
                $notification .= '<div class="notification-pic">';

                $filename = $this->config->item('job_profile_thumb_upload_path') . $total['user_image'];
                $s3 = new S3(awsAccessKey, awsSecretKey);
                $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                if ($total['user_image'] != '' && $info) {
                    $notification .= '<img src="' . JOB_PROFILE_THUMB_UPLOAD_URL . $total['user_image'] . '" alt="'.$total['user_image'].'">';
                } else {
                    $a = $total['first_name'];
                    $b = $total['last_name'];
                    $acr = substr($a, 0, 1);
                    $bcr = substr($b, 0, 1);

                    $notification .= '<div class="post-img-div">';
                    $notification .= '' . ucwords($acr) . ucwords($bcr) . '';
                    $notification .= '</div>';
                }
                $notification .= '</div><div class="notification-data-inside">';
                $notification .= '<h6><font color="black"><b><span class="noti-msg-y"> Job seeker</span></font></b><b>' . '  ' . ucwords($total['first_name']) . ' ' . ucwords($total['last_name']) . '</b> <span class="noti-msg-y"> Applied on your jobpost. </sapn></h6>';
                $notification .= '<div ><i class="clockimg" ></i><span class="day-text">';
                $notification .= '' . $this->common->time_elapsed_string($total['not_created_date'], $full = false) . '';
                $notification .= '</sapn></div></div> </div></a> </li>';
            }
            //17
            if ($total['not_from'] == 4) {

                $notification .= '<li class="';
                if ($total['not_active'] == 1) {
                    $notification .= 'active2';
                }
                $apply_slug = $this->db->select('freelancer_apply_slug')->get_where('freelancer_post_reg', array('user_id' => $total['not_from_id']))->row()->freelancer_apply_slug;
                $notification .= '"';
                $notification .= '><a href="' . base_url('freelance-work/freelancer-details/' . $apply_slug ) . '" onClick="not_active(' . $total['not_id'] . ')"><div class="notification-database">';
                $notification .= '<div class="notification-pic">';
                $filename = $this->config->item('free_post_profile_thumb_upload_path') . $total['user_image'];
                    $s3 = new S3(awsAccessKey, awsSecretKey);
                    $filepath = $s3->getObjectInfo(bucket, $filename);


                   
                    if ($total['user_image'] && $filepath) {
                        $notification .= '<img src="' . FREE_POST_PROFILE_THUMB_UPLOAD_URL . $total['user_image'] . '" alt="'.$total['user_image'].'">';
                } else {
                    $a = $total['first_name'];
                    $b = $total['last_name'];
                    $acr = substr($a, 0, 1);
                    $bcr = substr($b, 0, 1);

                    $notification .= '<div class="post-img-div">';
                    $notification .= '' . ucwords($acr) . ucwords($bcr) . '';
                    $notification .= '</div>';
                }
                $notification .= '</div><div class="notification-data-inside">';
                $notification .= '<h6><font color="black"><b><span class="noti-msg-y">Freelancer</span></font></b><b>' . '  ' . ucwords($total['first_name']) . ' ' . ucwords($total['last_name']) . '</b> <span class="noti-msg-y"> Applied on your post. </span></h6>';
                $notification .= '<div ><i class="clockimg" ></i><span class="day-text">';
                $notification .= '' . $this->common->time_elapsed_string($total['not_created_date'], $full = false) . '';
                $notification .= '</span></div></div> </div></a> </li>';
            }
            //18
            if ($total['not_from'] == 5 && $total['not_type'] == 4) {

                $notification .= '<li class="';
                if ($total['not_active'] == 1) {
                    $notification .= 'active2';
                }
                $notification .= '"';
                $notification .= '><a href="' . base_url('notification/freelance-hire/' . $total['post_id']) . '" onClick="not_active(' . $total['not_id'] . ')"><div class="notification-database">';
                $notification .= '<div class="notification-pic">';
                 $filename = $this->config->item('free_hire_profile_thumb_upload_path') . $total['user_image'];
                    $s3 = new S3(awsAccessKey, awsSecretKey);
                    $filepath = $s3->getObjectInfo(bucket, $filename);


                    // $filepath = FCPATH . $this->config->item('art_profile_thumb_upload_path') . $total['user_image'];
                    if ($total['user_image'] && $filepath) {
                        $notification .= '<img src="' . FREE_HIRE_PROFILE_THUMB_UPLOAD_URL . $total['user_image'] . '" alt="'.$total['user_image'].'">';
                } else {
                    $a = $total['first_name'];
                    $b = $total['last_name'];
                    $acr = substr($a, 0, 1);
                    $bcr = substr($b, 0, 1);

                    $notification .= '<div class="post-img-div">';
                    $notification .= '' . ucwords($acr) . ucwords($bcr) . '';
                    $notification .= '</div>';
                }
                $notification .= '</div><div class="notification-data-inside">';
                $notification .= '<h6><font color="black"><b><span class="noti-msg-y">Employer</span></font></b><b>' . '  ' . ucwords($total['first_name']) . ' ' . ucwords($total['last_name']) . '</b> <span class="noti-msg-y"> Selected you for project. </span> </h6>';
                $notification .= '<div ><i class="clockimg" ></i><span class="day-text">';
                $notification .= '' . $this->common->time_elapsed_string($total['not_created_date'], $full = false) . '';
                $notification .= '</span></div></div> </div> </a></li>';
            }

            // 19 shortlisted
            if ($total['not_from'] == 5 && $total['not_type'] == 9) {
                $notification .= '<li class="';
                if ($total['not_active'] == 1) {
                    $notification .= 'active2';
                }
                $notification .= '"';
                $notification .= '><a href="' . base_url('notification/freelance-hire/' . $total['post_id']) . '" onClick="not_active(' . $total['not_id'] . ')"><div class="notification-database">';
                $notification .= '<div class="notification-pic">';
                 $filename = $this->config->item('free_hire_profile_thumb_upload_path') . $total['user_image'];
                    $s3 = new S3(awsAccessKey, awsSecretKey);
                    $filepath = $s3->getObjectInfo(bucket, $filename);


                    if ($total['user_image'] && $filepath) {
                        $notification .= '<img src="' . FREE_HIRE_PROFILE_THUMB_UPLOAD_URL . $total['user_image'] . '" alt="'.$total['user_image'].'">';
                } else {
                    $a = $total['first_name'];
                    $b = $total['last_name'];
                    $acr = substr($a, 0, 1);
                    $bcr = substr($b, 0, 1);

                    $notification .= '<div class="post-img-div">';
                    $notification .= '' . ucwords($acr) . ucwords($bcr) . '';
                    $notification .= '</div>';
                }
                $notification .= '</div><div class="notification-data-inside">';
                $notification .= '<h6><font color="black"><b><span class="noti-msg-y">Employer</span></font></b><b>' . '  ' . ucwords($total['first_name']) . ' ' . ucwords($total['last_name']) . '</b> <span class="noti-msg-y"> Shortlisted you for project. </span> </h6>';
                $notification .= '<div ><i class="clockimg" ></i><span class="day-text">';
                $notification .= '' . $this->common->time_elapsed_string($total['not_created_date'], $full = false) . '';
                $notification .= '</span></div></div> </div> </a></li>';
            }

            $i++;
            if ($i == 10) {
                break;
            }
        }
        if ($totalnotification) {
            $seeall = '<a href="' . base_url() . 'notification">See All</a>';
        } else {
            $seeall = '<div class="fw">
  <div class="art-img-nn">
                                                <div class="art_no_post_img">
                                                    <img src="' . base_url() . 'assets/img/icon_notification_big.png" alt="notificationlogo">
                                                </div>
                                                <div class="art_no_post_text_c">
                                                    No Notification Available.
                                                </div>
                             </div></div>';
        }



        echo json_encode(
                array(
                    "notification" => $notification,
                    "seeall" => $seeall,
        ));
    }

    public function msg_header($id = "") {
        $message_from_profile = $_POST['message_from_profile'];
        $message_to_profile = $_POST['message_to_profile'];

        $this->data['userid'] = $userid = $this->session->userdata('aileenuser');
        // last message user fetch

        if ($id == "") {
            $contition_array = array('id !=' => '');

            $search_condition = "(message_from = '$userid' OR message_to = '$userid')";

            $lastuser = $this->common->select_data_by_search('messages', $search_condition, $contition_array, $data = 'messages.message_from,message_to,id', $sortby = 'id', $orderby = 'DESC', $limit = '1', $offset = '', $join_str = '', $groupby = '');

            if ($lastuser[0]['message_from'] == $userid) {

                $id = $this->data['lstusr'] = $lastuser[0]['message_to'];
            } else {

                $id = $this->data['lstusr'] = $lastuser[0]['message_from'];
            }
        }    // from job 22-7 end
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
            $this->data['last_user_data']['user_name'] = $last_user_data[0]['rec_firstname'] . ' ' . $last_user_data[0]['rec_lastname'];
            if ($last_user_data[0]['recruiter_user_image'] != '') {
                $this->data['last_user_data']['user_image'] = base_url() . 'uploads/recruiter_profile/thumbs/' . $last_user_data[0]['recruiter_user_image'];
            } else {
                $this->data['last_user_data']['user_image'] = base_url() . NOIMAGE;
            }
            $this->data['last_user_data']['user_designation'] = $last_user_data[0]['designation'] == '' ? 'Current Work' : $last_user_data[0]['designation'];

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
            $last_user_data = $this->common->select_data_by_condition('job_reg', $contition_array, $data = 'job_id,fname,lname,job_user_image,designation,user_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $this->data['last_user_data']['user_profile_id'] = $last_user_data[0]['rec_id'];
            $this->data['last_user_data']['user_name'] = $last_user_data[0]['fname'] . ' ' . $last_user_data[0]['lname'];
            if ($last_user_data[0]['job_user_image'] != '') {
                $this->data['last_user_data']['user_image'] = base_url() . 'uploads/job_profile/thumbs/' . $last_user_data[0]['job_user_image'];
            } else {
                $this->data['last_user_data']['user_image'] = base_url() . NOIMAGE;
            }
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
            $last_user_data = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data = 'freelancer_post_reg_id,freelancer_post_username,freelancer_post_fullname,freelancer_post_user_image,user_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $this->data['last_user_data']['user_profile_id'] = $last_user_data[0]['freelancer_post_reg_id'];
            $this->data['last_user_data']['user_name'] = $last_user_data[0]['freelancer_post_fullname'] . ' ' . $last_user_data[0]['freelancer_post_username'];
            if ($last_user_data[0]['freelancer_post_user_image'] != '') {
                $this->data['last_user_data']['user_image'] = base_url() . 'uploads/freelancer_post_profile/thumbs/' . $last_user_data[0]['freelancer_post_user_image'];
            } else {
                $this->data['last_user_data']['user_image'] = base_url() . NOIMAGE;
            }
            $this->data['last_user_data']['user_designation'] = $last_user_data[0]['designation'] == '' ? 'Current Work' : $last_user_data[0]['designation'];

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
            $last_user_data = $this->common->select_data_by_condition('freelancer_hire_reg', $contition_array, $data = 'reg_id,username,fullname,freelancer_hire_user_image,user_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $this->data['last_user_data']['user_profile_id'] = $last_user_data[0]['rec_id'];
            $this->data['last_user_data']['user_name'] = $last_user_data[0]['fullname'] . ' ' . $last_user_data[0]['username'];
            if ($last_user_data[0]['freelancer_hire_user_image'] != '') {
                $this->data['last_user_data']['user_image'] = base_url() . 'uploads/freelancer_hire_profile/thumbs/' . $last_user_data[0]['freelancer_hire_user_image'];
            } else {
                $this->data['last_user_data']['user_image'] = base_url() . NOIMAGE;
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
            $contition_array = array('user_id' => $userid, 'business_profile.is_deleted' => '0', 'status' => '1');
            $last_user_data = $this->common->select_data_by_condition('business_profile', $contition_array, $data = 'business_profile_id,company_name,business_user_image,user_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $this->data['last_user_data']['user_profile_id'] = $last_user_data[0]['business_profile_id'];
            $this->data['last_user_data']['user_name'] = $last_user_data[0]['company_name'];
            if ($last_user_data[0]['business_user_image'] != '') {
                $this->data['last_user_data']['user_image'] = base_url() . 'uploads/business_profile/thumbs/' . $last_user_data[0]['business_user_image'];
            } else {
                $this->data['last_user_data']['user_image'] = base_url() . NOIMAGE;
            }
            $this->data['last_user_data']['user_designation'] = $last_user_data[0]['designation'] == '' ? 'Current Work' : $last_user_data[0]['designation'];

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
            $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1');
            $last_user_data = $this->common->select_data_by_condition('art_reg', $contition_array, $data = 'art_id,art_name,art_lastname,art_user_image,user_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $this->data['last_user_data']['user_profile_id'] = $last_user_data[0]['art_id'];
            $this->data['last_user_data']['user_name'] = $last_user_data[0]['art_name'] . ' ' . $last_user_data[0]['art_lastname'];
            if ($last_user_data[0]['art_user_image'] != '') {
                $this->data['last_user_data']['user_image'] = base_url() . 'uploads/business_profile/thumbs/' . $last_user_data[0]['art_user_image'];
            } else {
                $this->data['last_user_data']['user_image'] = base_url() . NOIMAGE;
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
        $search_condition = "(message_from = '$userid' OR message_to = '$userid') AND ((message_from_profile = $message_from_profile AND message_to_profile = $message_to_profile) OR (message_from_profile = $message_to_profile AND message_to_profile = $message_from_profile)) AND (message_from_profile_id = $message_from_profile_id OR message_to_profile_id = $message_from_profile_id)";
        $lastchat = $this->common->select_data_by_search('messages', $search_condition, $contition_array, $data = 'messages.message_from,message_to,id', $sortby = 'id', $orderby = 'DESC', $limit = '1', $offset = '', $join_str = '', $groupby = '');

        if ($id) {
            $toid = $this->data['toid'] = $id;
        } elseif ($lastchat[0]['message_from'] == $userid) {
            $toid = $this->data['toid'] = $lastchat[0]['message_to'];
        } else {
            $toid = $this->data['toid'] = $lastchat[0]['message_from'];
        }

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
        $search_condition = "(message_from = '$id' OR message_to = '$id')  AND ((message_from_profile = $message_from_profile AND message_to_profile = $message_to_profile) OR (message_from_profile = $message_to_profile AND message_to_profile = $message_from_profile)) AND (message_from_profile_id = $message_from_profile_id OR message_to_profile_id = $message_from_profile_id)";
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

            $this->data['lstfname'] = $lastuser[0]['first_name'];
            $this->data['lstlname'] = $lastuser[0]['last_name'];
        }
        // slected user chat to

        $contition_array = array('is_delete' => '0', 'status' => '1');
        $search_condition = "((message_from = '$id' OR message_to = '$id') && (message_to != '$userid'))  AND ((message_from_profile = $message_from_profile AND message_to_profile = $message_to_profile) OR (message_from_profile = $message_to_profile AND message_to_profile = $message_from_profile)) AND (message_from_profile_id = $message_from_profile_id OR message_to_profile_id = $message_from_profile_id) AND is_message_from_delete != $userid AND is_message_to_delete != $userid";

        if ($message_from_profile == 2) {
            $join_str1[0]['table'] = 'messages';
            $join_str1[0]['join_table_id'] = 'messages.message_to';
            $join_str1[0]['from_table_id'] = 'job_reg.user_id';
            $join_str1[0]['join_type'] = '';

            $seltousr = $this->common->select_data_by_search('job_reg', $search_condition, $contition_array, $data = 'messages.id,message_to,fname as first_name,lname as last_name,job_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'DESC', $limit = '', $offset = '', $join_str1, $groupby = '');
        }
        if ($message_from_profile == 1) {
            $join_str1[0]['table'] = 'messages';
            $join_str1[0]['join_table_id'] = 'messages.message_to';
            $join_str1[0]['from_table_id'] = 'recruiter.user_id';
            $join_str1[0]['join_type'] = '';
            $contition_array = array('is_delete' => '0', 're_status' => '1');
            $seltousr = $this->common->select_data_by_search('recruiter', $search_condition, $contition_array, $data = 'messages.id,message_to,rec_firstname as first_name,rec_lastname as last_name,recruiter_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'DESC', $limit = '', $offset = '', $join_str1, $groupby = '');
        }
        if ($message_from_profile == 4) {
            $join_str1[0]['table'] = 'messages';
            $join_str1[0]['join_table_id'] = 'messages.message_to';
            $join_str1[0]['from_table_id'] = 'freelancer_hire_reg.user_id';
            $join_str1[0]['join_type'] = '';

            $seltousr = $this->common->select_data_by_search('freelancer_hire_reg', $search_condition, $contition_array, $data = 'messages.id,message_to,username as last_name,fullname as first_name,freelancer_hire_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'DESC', $limit = '', $offset = '', $join_str1, $groupby = '');
        }
        if ($message_from_profile == 3) {
            $join_str1[0]['table'] = 'messages';
            $join_str1[0]['join_table_id'] = 'messages.message_to';
            $join_str1[0]['from_table_id'] = 'freelancer_post_reg.user_id';
            $join_str1[0]['join_type'] = '';

            $seltousr = $this->common->select_data_by_search('freelancer_post_reg', $search_condition, $contition_array, $data = 'messages.id,message_to,freelancer_post_fullname as first_name,freelancer_post_username as last_name,freelancer_post_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'DESC', $limit = '', $offset = '', $join_str1, $groupby = '');
        }
        if ($message_from_profile == 5) {
            $join_str1[0]['table'] = 'messages';
            $join_str1[0]['join_table_id'] = 'messages.message_to';
            $join_str1[0]['from_table_id'] = 'business_profile.user_id';
            $join_str1[0]['join_type'] = '';
            $contition_array = array('business_profile.is_deleted' => '0', 'status' => '1');
            $seltousr = $this->common->select_data_by_search('business_profile', $search_condition, $contition_array, $data = 'messages.id,message_to,company_name as first_name,business_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'DESC', $limit = '', $offset = '', $join_str1, $groupby = '');
        }
        if ($message_from_profile == 6) {
            $join_str1[0]['table'] = 'messages';
            $join_str1[0]['join_table_id'] = 'messages.message_to';
            $join_str1[0]['from_table_id'] = 'art_reg.user_id';
            $join_str1[0]['join_type'] = '';

            $seltousr = $this->common->select_data_by_search('art_reg', $search_condition, $contition_array, $data = 'messages.id,message_to,art_name as first_name,art_lastname as last_name,art_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'DESC', $limit = '', $offset = '', $join_str1, $groupby = '');
        }

        // slected user chat from

        $contition_array = array('is_delete' => '0', 'status' => '1');
        $search_condition = "((message_from = '$id' OR message_to = '$id') && (message_from != '$userid')) AND ((message_from_profile = $message_from_profile AND message_to_profile = $message_to_profile) OR (message_from_profile = $message_to_profile AND message_to_profile = $message_from_profile)) AND (message_from_profile_id = $message_from_profile_id OR message_to_profile_id = $message_from_profile_id) AND is_message_from_delete != $userid AND is_message_to_delete != $userid";

        if ($message_from_profile == 2) {
            $join_str2[0]['table'] = 'messages';
            $join_str2[0]['join_table_id'] = 'messages.message_from';
            $join_str2[0]['from_table_id'] = 'job_reg.user_id';
            $join_str2[0]['join_type'] = '';

            $selfromusr = $this->common->select_data_by_search('job_reg', $search_condition, $contition_array, $data = 'messages.id,message_from,fname as first_name,lname as last_name,job_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'DESC', $limit = '', $offset = '', $join_str2, $groupby = '');
        }
        if ($message_from_profile == 1) {
            $join_str2[0]['table'] = 'messages';
            $join_str2[0]['join_table_id'] = 'messages.message_from';
            $join_str2[0]['from_table_id'] = 'recruiter.user_id';
            $join_str2[0]['join_type'] = '';
            $contition_array = array('is_delete' => '0', 're_status' => '1');
            $selfromusr = $this->common->select_data_by_search('recruiter', $search_condition, $contition_array, $data = 'messages.id,message_from,rec_firstname as first_name,rec_lastname as last_name,recruiter_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'DESC', $limit = '', $offset = '', $join_str2, $groupby = '');
        }
        if ($message_from_profile == 4) {
            $join_str2[0]['table'] = 'messages';
            $join_str2[0]['join_table_id'] = 'messages.message_from';
            $join_str2[0]['from_table_id'] = 'freelancer_hire_reg.user_id';
            $join_str2[0]['join_type'] = '';

            $selfromusr = $this->common->select_data_by_search('freelancer_hire_reg', $search_condition, $contition_array, $data = 'messages.id,message_from,username as last_name,fullname as first_name,freelancer_hire_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'DESC', $limit = '', $offset = '', $join_str2, $groupby = '');
        }
        if ($message_from_profile == 3) {
            $join_str2[0]['table'] = 'messages';
            $join_str2[0]['join_table_id'] = 'messages.message_from';
            $join_str2[0]['from_table_id'] = 'freelancer_post_reg.user_id';
            $join_str2[0]['join_type'] = '';

            $selfromusr = $this->common->select_data_by_search('freelancer_post_reg', $search_condition, $contition_array, $data = 'messages.id,message_from,freelancer_post_fullname as first_name,freelancer_post_username as last_name,freelancer_post_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'DESC', $limit = '', $offset = '', $join_str2, $groupby = '');
        }
        if ($message_from_profile == 5) {
            $join_str2[0]['table'] = 'messages';
            $join_str2[0]['join_table_id'] = 'messages.message_from';
            $join_str2[0]['from_table_id'] = 'business_profile.user_id';
            $join_str2[0]['join_type'] = '';
            $contition_array = array('business_profile.is_deleted' => '0', 'status' => '1');
            $selfromusr = $this->common->select_data_by_search('business_profile', $search_condition, $contition_array, $data = 'messages.id,message_from,company_name as first_name,business_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'DESC', $limit = '', $offset = '', $join_str2, $groupby = '');
        }
        if ($message_from_profile == 6) {
            $join_str2[0]['table'] = 'messages';
            $join_str2[0]['join_table_id'] = 'messages.message_from';
            $join_str2[0]['from_table_id'] = 'art_reg.user_id';
            $join_str2[0]['join_type'] = '';

            $selfromusr = $this->common->select_data_by_search('art_reg', $search_condition, $contition_array, $data = 'messages.id,message_from,art_name as first_name,art_lastname as last_name,art_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'DESC', $limit = '', $offset = '', $join_str2, $groupby = '');
        }

        $selectuser = array_merge($seltousr, $selfromusr);
        $selectuser = $this->aasort($selectuser, "id");

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

        if ($message_from_profile == 2) {
            $join_str3[0]['table'] = 'messages';
            $join_str3[0]['join_table_id'] = 'messages.message_to';
            $join_str3[0]['from_table_id'] = 'job_reg.user_id';
            $join_str3[0]['join_type'] = '';

            $tolist = $this->common->select_data_by_search('job_reg', $search_condition, $contition_array, $data = 'messages.id,message_to,fname as first_name,lname as last_name,job_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'ASC', $limit = '', $offset = '', $join_str3, $groupby = '');
        }
        if ($message_from_profile == 1) {
            $join_str3[0]['table'] = 'messages';
            $join_str3[0]['join_table_id'] = 'messages.message_to';
            $join_str3[0]['from_table_id'] = 'recruiter.user_id';
            $join_str3[0]['join_type'] = '';
            $contition_array = array('is_delete' => '0', 're_status' => '1');
            $tolist = $this->common->select_data_by_search('recruiter', $search_condition, $contition_array, $data = 'messages.id,message_to,rec_firstname as first_name,rec_lastname as last_name,recruiter_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'ASC', $limit = '', $offset = '', $join_str3, $groupby = '');
        }
        if ($message_from_profile == 4) {
            $join_str3[0]['table'] = 'messages';
            $join_str3[0]['join_table_id'] = 'messages.message_to';
            $join_str3[0]['from_table_id'] = 'freelancer_hire_reg.user_id';
            $join_str3[0]['join_type'] = '';

            $tolist = $this->common->select_data_by_search('freelancer_hire_reg', $search_condition, $contition_array, $data = 'messages.id,message_to,username as last_name,fullname as first_name,freelancer_hire_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'ASC', $limit = '', $offset = '', $join_str3, $groupby = '');
        }
        if ($message_from_profile == 3) {
            $join_str3[0]['table'] = 'messages';
            $join_str3[0]['join_table_id'] = 'messages.message_to';
            $join_str3[0]['from_table_id'] = 'freelancer_post_reg.user_id';
            $join_str3[0]['join_type'] = '';

            $tolist = $this->common->select_data_by_search('freelancer_post_reg', $search_condition, $contition_array, $data = 'messages.id,message_to,freelancer_post_fullname as first_name,freelancer_post_username as last_name,freelancer_post_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'ASC', $limit = '', $offset = '', $join_str3, $groupby = '');
        }
        if ($message_from_profile == 5) {
            $join_str3[0]['table'] = 'messages';
            $join_str3[0]['join_table_id'] = 'messages.message_to';
            $join_str3[0]['from_table_id'] = 'business_profile.user_id';
            $join_str3[0]['join_type'] = '';
            $contition_array = array('business_profile.is_deleted' => '0', 'status' => '1');
            $tolist = $this->common->select_data_by_search('business_profile', $search_condition, $contition_array, $data = 'messages.id,message_to,company_name as first_name,business_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'ASC', $limit = '', $offset = '', $join_str3, $groupby = '');
        }
        if ($message_from_profile == 6) {
            $join_str3[0]['table'] = 'messages';
            $join_str3[0]['join_table_id'] = 'messages.message_to';
            $join_str3[0]['from_table_id'] = 'art_reg.user_id';
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

        if ($message_from_profile == 2) {
            $join_str4[0]['table'] = 'messages';
            $join_str4[0]['join_table_id'] = 'messages.message_from';
            $join_str4[0]['from_table_id'] = 'job_reg.user_id';
            $join_str4[0]['join_type'] = '';

            $fromlist = $this->common->select_data_by_search('job_reg', $search_condition, $contition_array, $data = 'messages.id,message_from,fname as first_name,lname as last_name,job_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'ASC', $limit = '', $offset = '', $join_str4, $groupby = '');
        }
        if ($message_from_profile == 1) {
            $join_str4[0]['table'] = 'messages';
            $join_str4[0]['join_table_id'] = 'messages.message_from';
            $join_str4[0]['from_table_id'] = 'recruiter.user_id';
            $join_str4[0]['join_type'] = '';
            $contition_array = array('is_delete' => '0', 're_status' => '1');
            $fromlist = $this->common->select_data_by_search('recruiter', $search_condition, $contition_array, $data = 'messages.id,message_from,rec_firstname as first_name,rec_lastname as last_name,recruiter_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'ASC', $limit = '', $offset = '', $join_str4, $groupby = '');
        }
        if ($message_from_profile == 4) {
            $join_str4[0]['table'] = 'messages';
            $join_str4[0]['join_table_id'] = 'messages.message_from';
            $join_str4[0]['from_table_id'] = 'freelancer_hire_reg.user_id';
            $join_str4[0]['join_type'] = '';

            $fromlist = $this->common->select_data_by_search('freelancer_hire_reg', $search_condition, $contition_array, $data = 'messages.id,message_from,username as last_name,fullname as first_name,freelancer_hire_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'ASC', $limit = '', $offset = '', $join_str4, $groupby = '');
        }
        if ($message_from_profile == 3) {
            $join_str4[0]['table'] = 'messages';
            $join_str4[0]['join_table_id'] = 'messages.message_from';
            $join_str4[0]['from_table_id'] = 'freelancer_post_reg.user_id';
            $join_str4[0]['join_type'] = '';

            $fromlist = $this->common->select_data_by_search('freelancer_post_reg', $search_condition, $contition_array, $data = 'messages.id,message_from,freelancer_post_fullname as first_name,freelancer_post_username as last_name,freelancer_post_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'ASC', $limit = '', $offset = '', $join_str4, $groupby = '');
        }
        if ($message_from_profile == 5) {
            $join_str4[0]['table'] = 'messages';
            $join_str4[0]['join_table_id'] = 'messages.message_from';
            $join_str4[0]['from_table_id'] = 'business_profile.user_id';
            $join_str4[0]['join_type'] = '';
            $contition_array = array('business_profile.is_deleted' => '0', 'status' => '1');
            $fromlist = $this->common->select_data_by_search('business_profile', $search_condition, $contition_array, $data = 'messages.id,message_from,company_name as first_name,business_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'ASC', $limit = '', $offset = '', $join_str4, $groupby = '');
        }
        if ($message_from_profile == 6) {
            $join_str4[0]['table'] = 'messages';
            $join_str4[0]['join_table_id'] = 'messages.message_from';
            $join_str4[0]['from_table_id'] = 'art_reg.user_id';
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


        $user_message = array_merge($return_arraysel, $userlist);
        
        foreach ($user_message as $msg) {
            $job_slug = $this->db->get_where('job_reg', array('user_id' => $id))->row()->slug;
            if ($message_from_profile == 2) {
                $image_path = FCPATH . 'uploads/job_profile/thumbs/' . $msg['user_image'];
                $user_image = base_url() . 'uploads/job_profile/thumbs/' . $msg['user_image'];
                $profile_url = base_url() . 'job/resume/' . $job_slug . '?page=recruiter';
            }

            if ($message_from_profile == 1) {
                $image_path = FCPATH . 'uploads/recruiter_profile/thumbs/' . $msg['user_image'];
                $user_image = base_url() . 'uploads/recruiter_profile/thumbs/' . $msg['user_image'];
                $profile_url = base_url() . 'recruiter/rec_profile/' . $id . '?page=job';
            }
            if ($message_from_profile == 4) {
                $apply_slug = $this->db->select('freelancer_apply_slug')->get_where('freelancer_post_reg', array('user_id' => $id))->row()->freelancer_apply_slug;
                $image_path = FCPATH . 'uploads/freelancer_hire_profile/thumbs/' . $msg['user_image'];
                $user_image = base_url() . 'uploads/freelancer_hire_profile/thumbs/' . $msg['user_image'];
                $profile_url = base_url() . 'freelance-work/freelancer-details/' . $apply_slug;
            }
            if ($message_from_profile == 3) {
                $hire_slug = $this->db->select('freelancer_hire_slug')->get_where('freelancer_hire_reg', array('user_id' => $id))->row()->freelancer_hire_slug;
                $image_path = FCPATH . 'uploads/freelancer_post_profile/thumbs/' . $msg['user_image'];
                $user_image = base_url() . 'uploads/freelancer_post_profile/thumbs/' . $msg['user_image'];
                $profile_url = base_url() . 'freelance-hire/employer-details/' . $hire_slug;
            }
            if ($message_from_profile == 5) {
                $image_path = FCPATH . 'uploads/business_profile/thumbs/' . $msg['user_image'];
                $user_image = base_url() . 'uploads/business_profile/thumbs/' . $msg['user_image'];
                $busdata = $this->common->select_data_by_id('business_profile', 'user_id', $id, $data = 'business_slug');
                $profile_url = base_url() . 'business_profile/business_profile_manage_post/' . $busdata[0]['business_slug'];
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
            }
            $notmsg .= '">';
            $notmsg .= '<a href="' . base_url() . 'chat/abc/' . $msg['user_id'] . '/' . $message_from_profile . '/' . $message_to_profile . '/' . $not[0]['not_id'] . '" class="clearfix msg_dot" style="padding:0px!important;">';
            $notmsg .= '<div class="notification-database"><div class="notification-pic">';


            if ($msg['user_image'] && (file_exists($image_path)) == 1) {
                $notmsg .= '<img src="' . $user_image . '" alt="' . $user_image . '">';
            } else {
                $a = $msg['first_name'];
                $b = $msg['last_name'];
                $acr = substr($a, 0, 1);
                $bcr = substr($b, 0, 1);

                $notmsg .= '<div class="post-img-div">';
                $notmsg .= '' . ucwords($acr) . ucwords($bcr) . '';
                $notmsg .= '</div>';
            }

            $notmsg .= '</div><div class="notification-data-inside">';
            $notmsg .= '<h6>' . ucwords($msg['first_name']) . '</h6>';
            $notmsg .= '<div class="msg_desc_a">';

            $message = str_replace('\\r', '', $msg['message']);
            $message = str_replace('\\t', '', $message);
            $message = str_replace('\\', '', $message);
            $message = str_replace('%26amp;', '&', $message);


            $notmsg .= '' . $message . '';
            $notmsg .= '</div><div class="data_noti_msg"><span class="day-text2">' . $this->common->time_elapsed_string(date('Y-m-d H:i:s', strtotime($not[0]['not_created_date']))) . '</span></div>';
            $notmsg .= '</div></div></a></li>';
        }
        $notmsg .= '</div>';
        echo $notmsg;
    }

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

    public function not_active() {

        $not_id = $this->input->post('not_id');
        $data = array(
            'not_active' => '2'
        );
        $updatedata = $this->common->update_data($data, 'notification', 'not_id', $not_id);
    }

    public function not_view() {
        $data = '<ul class="">
        <li class=""><a href="http://localhost/aileensoul/chat/abc/93/6/6/184" class="clearfix msg_dot" style="padding:0px!important;"><div class="notification-database"><div class="notification-pic"><div class="post-img-div">ZP</div></div><div class="notification-data-inside"><h6>Zalak</h6><div class="msg_desc_a">z4</div><div class="data_noti_msg"><span class="day-text2">1 hour ago</span></div></div></div></a></li>
    <li class="active2">
        <a href="http://localhost/aileensoul/business-profile/details/zalak-infotech-pvt-ltd" onclick="not_active(1422)">
            <div class="notification-database">
                <div class="notification-pic">
                    <div class="post-img-div">Z</div>
                </div>
                <div class="notification-data-inside">
                    <h6><b>  Zalak Infotech Pvt Ltd</b> <span class="noti-msg-y">Started following you in business profile.</span></h6>
                    <div><i class="clockimg"></i><span class="day-text">3 days ago</span>
                    </div>
                </div>
            </div>
        </a>
    </li>
    <li class="active2">
        <a href="http://localhost/aileensoul/business-profile/details/zalak-infotech-pvt-ltd" onclick="not_active(1387)">
            <div class="notification-database">
                <div class="notification-pic">
                    <div class="post-img-div">Z</div>
                </div>
                <div class="notification-data-inside">
                    <h6><b>  Zalak Infotech Pvt Ltd</b> <span class="noti-msg-y">Started following you in business profile.</span></h6>
                    <div><i class="clockimg"></i><span class="day-text">1 week ago</span>
                    </div>
                </div>
            </div>
        </a>
    </li>
    <li class="active2">
        <a href="http://localhost/aileensoul/notification/business-profile-post/60" onclick="not_active(1366)">
            <div class="notification-database">
                <div class="notification-pic"><img src="http://localhost/aileensoul/uploads/business_profile/thumbs/images.png" alt="uploadimage">
                </div>
                <div class="notification-data-inside">
                    <h6><b>  Abhinandan Hosiery</b> <span class="noti-msg-y"> Likes your post in business profile. </span> </h6>
                    <div><i class="clockimg"></i><span class="day-text">2 weeks ago</span>
                    </div>
                </div>
            </div>
        </a>
    </li>
    <li class="active2">
        <a href="http://localhost/aileensoul/business-profile/details/hemstechnosys-pvt-ltd" onclick="not_active(1270)">
            <div class="notification-database">
                <div class="notification-pic">
                    <div class="post-img-div">H</div>
                </div>
                <div class="notification-data-inside">
                    <h6><b>  HEMSTECHNOSYS PVT. LTD.</b> <span class="noti-msg-y">Started following you in business profile.</span></h6>
                    <div><i class="clockimg"></i><span class="day-text">3 weeks ago</span>
                    </div>
                </div>
            </div>
        </a>
    </li>
    <li class="active2">
        <a href="http://localhost/aileensoul/business-profile/details/rout-digital-duniya" onclick="not_active(1195)">
            <div class="notification-database">
                <div class="notification-pic"><img src="http://localhost/aileensoul/uploads/business_profile/thumbs/index3.jpg" alt="index.png">
                </div>
                <div class="notification-data-inside">
                    <h6><b>  ROUT DIGITAL DUNIYA</b> <span class="noti-msg-y">Started following you in business profile.</span></h6>
                    <div><i class="clockimg"></i><span class="day-text">3 weeks ago</span>
                    </div>
                </div>
            </div>
        </a>
    </li>
    <li class="active2">
        <a href="http://localhost/aileensoul/business-profile/details/abhinandan-hosiery" onclick="not_active(1154)">
            <div class="notification-database">
                <div class="notification-pic"><img src="http://localhost/aileensoul/uploads/business_profile/thumbs/images.png" alt="images.png">
                </div>
                <div class="notification-data-inside">
                    <h6><b>  Abhinandan Hosiery</b> <span class="noti-msg-y">Started following you in business profile.</span></h6>
                    <div><i class="clockimg"></i><span class="day-text">3 weeks ago</span>
                    </div>
                </div>
            </div>
        </a>
    </li>
    <li class="active2">
        <a href="http://localhost/aileensoul/notification/business-profile-post/65" onclick="not_active(1151)">
            <div class="notification-database">
                <div class="notification-pic"><img src="http://localhost/aileensoul/uploads/business_profile/thumbs/images.png" alt="images.png">
                </div>
                <div class="notification-data-inside">
                    <h6><b>  Abhinandan Hosiery</b> <span class="noti-msg-y"> Likes your post in business profile. </span> </h6>
                    <div><i class="clockimg"></i><span class="day-text">3 weeks ago</span>
                    </div>
                </div>
            </div>
        </a>
    </li>
    <li class="active2">
        <a href="http://localhost/aileensoul/notification/business-profile-post/66" onclick="not_active(1150)">
            <div class="notification-database">
                <div class="notification-pic"><img src="http://localhost/aileensoul/uploads/business_profile/thumbs/images.png" alt="images.png">
                </div>
                <div class="notification-data-inside">
                    <h6><b>  Abhinandan Hosiery</b> <span class="noti-msg-y"> Likes your post in business profile. </span> </h6>
                    <div><i class="clockimg"></i><span class="day-text">3 weeks ago</span>
                    </div>
                </div>
            </div>
        </a>
    </li>
    <li class="active2">
        <a href="http://localhost/aileensoul/notification/business-profile-post/67" onclick="not_active(1149)">
            <div class="notification-database">
                <div class="notification-pic"><img src="http://localhost/aileensoul/uploads/business_profile/thumbs/images.png" alt="images.png">
                </div>
                <div class="notification-data-inside">
                    <h6><b>  Abhinandan Hosiery</b> <span class="noti-msg-y"> Likes your post in business profile. </span> </h6>
                    <div><i class="clockimg"></i><span class="day-text">3 weeks ago</span>
                    </div>
                </div>
            </div>
        </a>
    </li>
    <li class="">
        <a href="http://localhost/aileensoul/artist/artistic_profile/318" onclick="not_active(1126)">
            <div class="notification-database">
                <div class="notification-pic">
                    <div class="post-img-div">DP</div>
                </div>
                <div class="notification-data-inside">
                    <h6><b>  Dhruti Panchal</b> <span class="noti-msg-y"> Started following you in artistic profile.</span></h6>
                    <div><i class="clockimg"></i><span class="day-text">1 month ago</span>
                    </div>
                </div>
            </div>
        </a>
    </li>
</ul>';
        echo $data;
    }

    public function ajax_notification_data() {
        //NOTIFICATION CODE START
        $perpage = 8;
        $page = 1;
        if (!empty($_GET["page"]) && $_GET["page"] != 'undefined') {
            $page = $_GET["page"];
        }

        $start = ($page - 1) * $perpage;
        if ($start < 0)
            $start = 0;
        $userid = $this->session->userdata('aileenuser');

        $contition_array = array('notification.not_type' => '3', 'notification.not_to_id' => $userid, 'notification.not_from' => '2', 'created_date BETWEEN DATE_SUB(NOW(), INTERVAL 2 MONTH) AND NOW()');
        $join_str = array(array(
                'join_type' => '',
                'table' => 'job_apply',
                'join_table_id' => 'notification.not_product_id',
                'from_table_id' => 'job_apply.app_id'),
            array(
                'join_type' => '',
                'table' => 'job_reg',
                'join_table_id' => 'notification.not_from_id',
                'from_table_id' => 'job_reg.user_id')
        );
        $data = array('notification.*', 'job_apply.*', 'job_reg.user_id as user_id', 'job_reg.fname as first_name', 'job_reg.job_user_image as user_image', 'job_reg.lname as last_name');
        $rec_not = $this->data['rec_not'] = $this->common->select_data_by_condition('notification', $contition_array, $data, $sortby = 'app_id', $orderby = 'desc', $limit = '', $offset = '', $join_str, $groupby = '');

        $contition_array = array('notification.not_type' => '4', 'notification.not_to_id' => $userid, 'created_date BETWEEN DATE_SUB(NOW(), INTERVAL 2 MONTH) AND NOW()');
        $join_str = array(array(
                'join_type' => '',
                'table' => 'job_apply',
                'join_table_id' => 'notification.not_product_id',
                'from_table_id' => 'job_apply.app_id'),
            array(
                'join_type' => '',
                'table' => 'recruiter',
                'join_table_id' => 'notification.not_from_id',
                'from_table_id' => 'recruiter.user_id')
        );
        $data = array('notification.*', ' job_apply.*', ' recruiter.user_id as user_id', 'recruiter.rec_firstname as first_name', 'recruiter.recruiter_user_image as user_image', 'recruiter.rec_lastname as last_name');

        $job_not = $this->data['job_not'] = $this->common->select_data_by_condition('notification', $contition_array, $data, $sortby = 'app_id', $orderby = 'desc', $limit = '', $offset = '', $join_str, $groupby = '');

        $contition_array = array('notification.not_type' => '3', 'notification.not_from' => '4', 'notification.not_to_id' => $userid, 'created_date BETWEEN DATE_SUB(NOW(), INTERVAL 2 MONTH) AND NOW()');

        $join_str = array(
            array(
                'join_type' => '',
                'table' => 'freelancer_apply',
                'join_table_id' => 'notification.not_product_id',
                'from_table_id' => 'freelancer_apply.app_id'),
            array(
                'join_type' => '',
                'table' => 'freelancer_post_reg',
                'join_table_id' => 'notification.not_from_id',
                'from_table_id' => 'freelancer_post_reg.user_id')
        );
        $data = array('notification.*', 'freelancer_apply.*', ' freelancer_post_reg.user_id as user_id', 'freelancer_post_reg.freelancer_post_fullname as first_name', 'freelancer_post_reg.freelancer_post_user_image as user_image', 'freelancer_post_reg.freelancer_post_username as last_name');

        $hire_not = $this->data['hire_noth'] = $this->common->select_data_by_condition('notification', $contition_array, $data, $sortby = 'app_id', $orderby = 'desc', $limit = '', $offset = '', $join_str, $groupby = '');
        // freelancer hire notification end
// freelancer post notification start
        $contition_array = array('notification.not_type' => '4', 'notification.not_from' => '5', 'notification.not_to_id' => $userid, 'created_date BETWEEN DATE_SUB(NOW(), INTERVAL 2 MONTH) AND NOW()');
        $join_str = array(array(
                'join_type' => '',
                'table' => 'user_invite',
                'join_table_id' => 'notification.not_product_id',
                'from_table_id' => 'user_invite.invite_id'),
            array(
                'join_type' => '',
                'table' => 'freelancer_hire_reg',
                'join_table_id' => 'notification.not_from_id',
                'from_table_id' => 'freelancer_hire_reg.user_id')
        );
        $data = array('notification.*', ' user_invite.*', 'freelancer_hire_reg.user_id as user_id', 'freelancer_hire_reg.fullname as first_name', 'freelancer_hire_reg.freelancer_hire_user_image as user_image', 'freelancer_hire_reg.username as last_name');

        $work_post = $this->data['work_post'] = $work_post = $this->common->select_data_by_condition('notification', $contition_array, $data, $sortby = 'invite_id', $orderby = 'desc', $limit = '', $offset = '', $join_str, $groupby = '');


// freelancer post notification end
//artistic notification start
// follow notification start

        $contition_array = array('notification.not_type' => '8', 'notification.not_from' => '3', 'notification.not_to_id' => $userid, 'created_date BETWEEN DATE_SUB(NOW(), INTERVAL 2 MONTH) AND NOW()');
        $join_str = array(array(
                'join_type' => '',
                'table' => 'follow',
                'join_table_id' => 'notification.not_product_id',
                'from_table_id' => 'follow.follow_id'),
            array(
                'join_type' => '',
                'table' => 'art_reg',
                'join_table_id' => 'notification.not_from_id',
                'from_table_id' => 'art_reg.user_id')
        );
        $data = array('notification.*', ' follow.*', ' art_reg.user_id as user_id', 'art_reg.art_name as first_name', 'art_reg.art_user_image as user_image', 'art_reg.art_lastname as last_name', ' art_reg.slug as slug');

        $artfollow = $this->data['artfollow'] = $this->common->select_data_by_condition('notification', $contition_array, $data, $sortby = 'follow_id', $orderby = 'desc', $limit = '', $offset = '', $join_str, $groupby = '');

// follow notification end
//post comment notification start

        $contition_array = array('notification.not_type' => '6', 'not_img' => '1', 'notification.not_from' => '3', 'notification.not_to_id' => $userid, 'created_date BETWEEN DATE_SUB(NOW(), INTERVAL 2 MONTH) AND NOW()');
        $join_str = array(array(
                'join_type' => '',
                'table' => 'artistic_post_comment',
                'join_table_id' => 'notification.not_product_id',
                'from_table_id' => 'artistic_post_comment.artistic_post_comment_id'),
            array(
                'join_type' => '',
                'table' => 'art_reg',
                'join_table_id' => 'notification.not_from_id',
                'from_table_id' => 'art_reg.user_id')
        );
        $data = array('notification.*', ' artistic_post_comment.*', 'art_reg.user_id as user_id', 'art_reg.art_name as first_name', 'art_reg.art_user_image as user_image', 'art_reg.art_lastname as last_name');
        $artcommnet = $this->data['artcommnet'] = $this->common->select_data_by_condition('notification', $contition_array, $data, $sortby = 'artistic_post_comment_id', $orderby = 'desc', $limit = '', $offset = '', $join_str, $groupby = '');
// comment notification end
//post like notification start
        $contition_array = array('notification.not_type' => '5', 'notification.not_from' => '3', 'not_img' => '2', 'notification.not_to_id' => $userid, 'created_date BETWEEN DATE_SUB(NOW(), INTERVAL 2 MONTH) AND NOW()');
        $join_str = array(array(
                'join_type' => '',
                'table' => 'art_post',
                'join_table_id' => 'notification.not_product_id',
                'from_table_id' => 'art_post.art_post_id'),
            array(
                'join_type' => '',
                'table' => 'art_reg',
                'join_table_id' => 'notification.not_from_id',
                'from_table_id' => 'art_reg.user_id')
        );
        $data = array('notification.*', 'art_post.*', 'art_reg.user_id as user_id', 'art_reg.art_name as first_name', 'art_reg.art_user_image as user_image', 'art_reg.art_lastname as last_name');
        $artlike = $this->data['artlike'] = $this->common->select_data_by_condition('notification', $contition_array, $data, $sortby = 'art_post_id', $orderby = 'desc', $limit = '', $offset = '', $join_str, $groupby = '');

        $contition_array = array('notification.not_type' => '5', 'not_img' => '5', 'notification.not_from' => '3', 'notification.not_to_id' => $userid, 'created_date BETWEEN DATE_SUB(NOW(), INTERVAL 2 MONTH) AND NOW()');
        $join_str = array(array(
                'join_type' => '',
                'table' => 'post_files',
                'join_table_id' => 'notification.not_product_id',
                'from_table_id' => 'post_files.post_files_id'),
            array(
                'join_type' => '',
                'table' => 'art_reg',
                'join_table_id' => 'notification.not_from_id',
                'from_table_id' => 'art_reg.user_id')
        );
        $data = array('notification.*', 'post_files.*', 'art_reg.user_id as user_id', 'art_reg.art_name as first_name', 'art_reg.art_user_image as user_image', 'art_reg.art_lastname as last_name');
        $artimglike = $this->data['artimglike'] = $this->common->select_data_by_condition('notification', $contition_array, $data, $sortby = 'post_files_id', $orderby = 'desc', $limit = '', $offset = '', $join_str, $groupby = '');


        $contition_array = array('notification.not_type' => '5', 'not_img' => '3', 'notification.not_from' => '3', 'notification.not_to_id' => $userid, 'created_date BETWEEN DATE_SUB(NOW(), INTERVAL 2 MONTH) AND NOW()');
        $join_str = array(array(
                'join_type' => '',
                'table' => 'artistic_post_comment',
                'join_table_id' => 'notification.not_product_id',
                'from_table_id' => 'artistic_post_comment.artistic_post_comment_id'),
            array(
                'join_type' => '',
                'table' => 'art_reg',
                'join_table_id' => 'notification.not_from_id',
                'from_table_id' => 'art_reg.user_id')
        );
        $data = array('notification.*', 'artistic_post_comment.*', 'art_reg.user_id as user_id', 'art_reg.art_name as first_name', 'art_reg.art_user_image as user_image', 'art_reg.art_lastname as last_name');
        $artcmtlike = $this->data['artcmtlike'] = $this->common->select_data_by_condition('notification', $contition_array, $data, $sortby = 'artistic_post_comment_id', $orderby = 'desc', $limit = '', $offset = '', $join_str, $groupby = '');

        $contition_array = array('notification.not_type' => '6', 'not_img' => '4', 'notification.not_from' => '3', 'notification.not_to_id' => $userid, 'created_date BETWEEN DATE_SUB(NOW(), INTERVAL 2 MONTH) AND NOW()');
        $join_str = array(array(
                'join_type' => '',
                'table' => 'art_post_image_comment',
                'join_table_id' => 'notification.not_product_id',
                'from_table_id' => 'art_post_image_comment.post_image_comment_id'),
            array(
                'join_type' => '',
                'table' => 'art_reg',
                'join_table_id' => 'notification.not_from_id',
                'from_table_id' => 'art_reg.user_id')
        );
        $data = array('notification.*', ' art_post_image_comment.*', 'art_reg.user_id as user_id', 'art_reg.art_name as first_name', 'art_reg.art_user_image as user_image', 'art_reg.art_lastname as last_name');
        $artimgcommnet = $this->data['artimgcommnet'] = $this->common->select_data_by_condition('notification', $contition_array, $data, $sortby = 'post_image_comment_id', $orderby = 'desc', $limit = '', $offset = '', $join_str, $groupby = '');

        $contition_array = array('notification.not_type' => '5', 'not_img' => '6', 'notification.not_from' => '3', 'notification.not_to_id' => $userid, 'created_date BETWEEN DATE_SUB(NOW(), INTERVAL 2 MONTH) AND NOW()');
        $join_str = array(array(
                'join_type' => '',
                'table' => 'art_post_image_comment',
                'join_table_id' => 'notification.not_product_id',
                'from_table_id' => 'art_post_image_comment.post_image_comment_id'),
            array(
                'join_type' => '',
                'table' => 'art_reg',
                'join_table_id' => 'notification.not_from_id',
                'from_table_id' => 'art_reg.user_id')
        );
        $data = array('notification.*', ' art_post_image_comment.*', 'art_reg.user_id as user_id', 'art_reg.art_name as first_name', 'art_reg.art_user_image as user_image', 'art_reg.art_lastname as last_name');
        $this->data['artimgcmtlike'] = $artimgcmtlike = $this->common->select_data_by_condition('notification', $contition_array, $data, $sortby = 'post_image_comment_id', $orderby = 'desc', $limit = '', $offset = '', $join_str, $groupby = '');

// like notification end
// artistic notification end
// business profile notification start
// follow notification start

        $contition_array = array('notification.not_type' => '8', 'notification.not_from' => '6', 'notification.not_to_id' => $userid, 'created_date BETWEEN DATE_SUB(NOW(), INTERVAL 2 MONTH) AND NOW()');
        $join_str = array(array(
                'join_type' => '',
                'table' => 'follow',
                'join_table_id' => 'notification.not_product_id',
                'from_table_id' => 'follow.follow_id'),
            array(
                'join_type' => '',
                'table' => 'business_profile',
                'join_table_id' => 'notification.not_from_id',
                'from_table_id' => 'business_profile.user_id')
        );
        $data = array('notification.*', 'follow.*', 'business_profile.user_id as user_id', 'business_profile.company_name as first_name', 'business_profile.business_user_image as user_image');
        $busifollow = $this->data['busifollow'] = $this->common->select_data_by_condition('notification', $contition_array, $data, $sortby = 'follow_id', $orderby = 'desc', $limit = '', $offset = '', $join_str, $groupby = '');

// follow notification end
// comment notification start

        $contition_array = array('notification.not_type' => '6', 'not_img' => '1', 'notification.not_from' => '6', 'notification.not_to_id' => $userid, 'created_date BETWEEN DATE_SUB(NOW(), INTERVAL 2 MONTH) AND NOW()');
        $join_str = array(array(
                'join_type' => '',
                'table' => 'business_profile_post_comment',
                'join_table_id' => 'notification.not_product_id',
                'from_table_id' => 'business_profile_post_comment.business_profile_post_comment_id'),
            array(
                'join_type' => '',
                'table' => 'business_profile',
                'join_table_id' => 'notification.not_from_id',
                'from_table_id' => 'business_profile.user_id')
        );
        $data = array('notification.*', 'business_profile_post_comment.*', 'business_profile.user_id as user_id', 'business_profile.company_name as first_name', 'business_profile.business_user_image as user_image');

        $buscommnet = $this->data['buscommnet'] = $this->common->select_data_by_condition('notification', $contition_array, $data, $sortby = 'business_profile_post_comment_id', $orderby = 'desc', $limit = '', $offset = '', $join_str, $groupby = '');
       $contition_array = array('notification.not_type' => '6', 'not_img' => '4', 'notification.not_from' => '6', 'notification.not_to_id' => $userid, 'created_date BETWEEN DATE_SUB(NOW(), INTERVAL 2 MONTH) AND NOW()');
        $join_str = array(array(
                'join_type' => '',
                'table' => 'bus_post_image_comment',
                'join_table_id' => 'notification.not_product_id',
                'from_table_id' => 'bus_post_image_comment.post_image_comment_id'),
            array(
                'join_type' => '',
                'table' => 'business_profile',
                'join_table_id' => 'notification.not_from_id',
                'from_table_id' => 'business_profile.user_id')
        );
        $data = array('notification.*', 'bus_post_image_comment.*', 'business_profile.user_id as user_id', 'business_profile.company_name as first_name', 'business_profile.business_user_image as user_image');

        $this->data['busimgcommnet'] = $busimgcommnet = $this->common->select_data_by_condition('notification', $contition_array, $data, $sortby = 'post_image_comment_id', $orderby = 'desc', $limit = '', $offset = '', $join_str, $groupby = '');

// comment notification end
// like notification start
        $contition_array = array('notification.not_type' => '5', 'not_img' => '2', 'notification.not_from' => '6', 'notification.not_to_id' => $userid, 'created_date BETWEEN DATE_SUB(NOW(), INTERVAL 2 MONTH) AND NOW()');
        $join_str = array(array(
                'join_type' => '',
                'table' => 'business_profile_post',
                'join_table_id' => 'notification.not_product_id',
                'from_table_id' => 'business_profile_post.business_profile_post_id'),
            array(
                'join_type' => '',
                'table' => 'business_profile',
                'join_table_id' => 'notification.not_from_id',
                'from_table_id' => 'business_profile.user_id')
        );
        $data = array('notification.*', ' business_profile_post.*', 'business_profile.user_id as user_id', 'business_profile.company_name as first_name', 'business_profile.business_user_image as user_image');

        $buslike = $this->data['buslike'] = $this->common->select_data_by_condition('notification', $contition_array, $data, $sortby = 'business_profile_post_id', $orderby = 'desc', $limit = '', $offset = '', $join_str, $groupby = '');

        $contition_array = array('notification.not_type' => '5', 'not_img' => '3', 'notification.not_from' => '6', 'notification.not_to_id' => $userid, 'created_date BETWEEN DATE_SUB(NOW(), INTERVAL 2 MONTH) AND NOW()');
        $join_str = array(array(
                'join_type' => '',
                'table' => 'business_profile_post_comment',
                'join_table_id' => 'notification.not_product_id',
                'from_table_id' => 'business_profile_post_comment.business_profile_post_comment_id'),
            array(
                'join_type' => '',
                'table' => 'business_profile',
                'join_table_id' => 'notification.not_from_id',
                'from_table_id' => 'business_profile.user_id')
        );
        $data = array('notification.*', 'business_profile_post_comment.*', 'business_profile.user_id as user_id', 'business_profile.company_name as first_name', 'business_profile.business_user_image as user_image');

        $buscmtlike = $this->data['buscmtlike'] = $this->common->select_data_by_condition('notification', $contition_array, $data, $sortby = 'business_profile_post_comment_id', $orderby = 'desc', $limit = '', $offset = '', $join_str, $groupby = '');

        $contition_array = array('notification.not_type' => '5', 'not_img' => '5', 'notification.not_from' => '6', 'notification.not_to_id' => $userid, 'created_date BETWEEN DATE_SUB(NOW(), INTERVAL 2 MONTH) AND NOW()');
        $join_str = array(array(
                'join_type' => '',
                'table' => 'post_files',
                'join_table_id' => 'notification.not_product_id',
                'from_table_id' => 'post_files.post_files_id'),
            array(
                'join_type' => '',
                'table' => 'business_profile',
                'join_table_id' => 'notification.not_from_id',
                'from_table_id' => 'business_profile.user_id')
        );
        $data = array('notification.*', 'post_files.*', 'business_profile.user_id as user_id', 'business_profile.company_name as first_name', 'business_profile.business_user_image as user_image');

        $busimglike = $this->data['busimglike'] = $this->common->select_data_by_condition('notification', $contition_array, $data, $sortby = 'post_files_id', $orderby = 'desc', $limit = '', $offset = '', $join_str, $groupby = '');

        $contition_array = array('notification.not_type' => '5', 'not_img' => '6', 'notification.not_from' => '6', 'notification.not_to_id' => $userid, 'created_date BETWEEN DATE_SUB(NOW(), INTERVAL 2 MONTH) AND NOW()');
        $join_str = array(array(
                'join_type' => '',
                'table' => 'bus_post_image_comment',
                'join_table_id' => 'notification.not_product_id',
                'from_table_id' => 'bus_post_image_comment.post_image_comment_id'),
            array(
                'join_type' => '',
                'table' => 'business_profile',
                'join_table_id' => 'notification.not_from_id',
                'from_table_id' => 'business_profile.user_id')
        );
        $data = array('notification.*', 'bus_post_image_comment.*', 'business_profile.user_id as user_id', 'business_profile.company_name as first_name', 'business_profile.business_user_image as user_image');

        $busimgcmtlike = $this->data['busimgcmtlike'] = $this->common->select_data_by_condition('notification', $contition_array, $data, $sortby = 'post_image_comment_id', $orderby = 'desc', $limit = '', $offset = '', $join_str, $groupby = '');

        $totalnotifi = $totalnotifi = array_merge((array) $rec_not, (array) $job_not, (array) $hire_not, (array) $work_post, (array) $artcommnet, (array) $artlike, (array) $artcmtlike, (array) $artimglike, (array) $artimgcommnet, (array) $artfollow, (array) $artimgcmtlike, (array) $busimgcommnet, (array) $busifollow, (array) $buscommnet, (array) $buslike, (array) $buscmtlike, (array) $busimgcmtlike, (array) $busimglike);
        $totalnotification = $this->aasort($totalnotifi, "not_id");

        //NOTIFICATION CODE END
        $return_html = '';

        $totalnotification1 = array_slice($totalnotification, $start, $perpage);
        if (empty($_GET["total_record"])) {
            $_GET["total_record"] = count($totalnotification);
        }

        $return_html .= '<input type = "hidden" class = "page_number" value = "' . $page . '" />';
        $return_html .= '<input type = "hidden" class = "total_record" value = "' . $_GET["total_record"] . '" />';
        $return_html .= '<input type = "hidden" class = "perpage_record" value = "' . $perpage . '" />';

        //NOTIFICATION DATA START
        if ($totalnotification) {
            foreach ($totalnotification1 as $total) {
                $abc = $total['not_id'];
                //1 
                if ($total['not_from'] == 1) {
                    $companyname = $this->db->get_where('recruiter', array('user_id' => $total['user_id']))->row()->re_comp_name;
                    $return_html .= '<li class="';
                    if ($total['not_active'] == 1) {
                        $return_html .= 'active2';
                    }
                    $return_html .= '">';
                    $return_html .= '<a href="' . base_url() . 'notification/recruiter_post/' . $total['post_id'] . '">';
                    $return_html .= '<div class="notification-pic" id="noti_pc" >';
      
                    $filename = $this->config->item('rec_profile_thumb_upload_path') . $total['user_image'];
                         $s3 = new S3(awsAccessKey, awsSecretKey);
                         $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                      if ($total['user_image'] != '' && $info) { 
                    $return_html .= '<img src="' . REC_PROFILE_THUMB_UPLOAD_URL . $total['user_image'] . '" alt="" >';
                    } else {
                        $a = $total['first_name'];
                        $b = $total['last_name'];
                        $acr = substr($a, 0, 1);
                        $bcr = substr($b, 0, 1);
                        $return_html .= '<div class="post-img-div">' .
                                ucwords($acr) . ucwords($bcr) .
                                '</div>';
                    }
                    $return_html .= '</div>
                                            <div class="notification-data-inside" id="notification_inside">
                                                <h6><b><i> Recruiter</i></font></b><b>' . '  ' . ucwords($total['first_name']) . ' ' . ucwords($total['last_name']) . '</b>  From ' . ucwords($companyname) . '  Invited you for an interview.</h6>
                                              <div  class="hout_noti">' .
                            $this->common->time_elapsed_string($total['not_created_date'], $full = false) .
                            '</div>
                                            </div>
                                            </a></li>';
                }


                //   2
                if ($total['not_from'] == 3 && $total['not_img'] == 0) {

                    $geturl = $this->get_url($total['user_id']);

                    
                    $return_html .= '<li class="';
                    if ($total['not_active'] == 1) {
                        $return_html .= 'active2';
                    } $return_html .= '">';
                    $return_html .= '<a href="' . base_url() . 'artist/dashboard/' . $geturl . '">';
                    $return_html .= '<div class="notification-pic" id="noti_pc">';


                    $filename = $this->config->item('art_profile_thumb_upload_path') . $total['user_image'];
                    $s3 = new S3(awsAccessKey, awsSecretKey);
                    $filepath = $s3->getObjectInfo(bucket, $filename);

                    if ($total['user_image'] && $filepath) {
                        $return_html .= '<img src="' . ART_PROFILE_THUMB_UPLOAD_URL . $total['user_image'] . '" alt="'.$total['user_image'].'">';
                    } else {
                        $return_html .= '<img src = "' . base_url(NOARTIMAGE) . '" alt = "noimage">';
                    }

                    $return_html .= '</div>
                                            
                                            <div class="notification-data-inside" id="notification_inside">
                                                <h6><b>' . ucwords($total['first_name']) . ' ' . ucwords($total['last_name']) . '</b> Started following you in artistic profile.</h6>
                                             <div  class="hout_noti">' .
                            $this->common->time_elapsed_string($total['not_created_date'], $full = false) .
                            '</div>
                                            </div>
                                            </a>
                                        </li>
                                        ';
                }


                // 3
                if ($total['not_from'] == 3) {
                    if ($total['not_img'] == 1) {

                        $return_html .= '<li class="';
                        if ($total['not_active'] == 1) {
                            $return_html .= 'active2';
                        } $return_html .= '">
                                         <a href="' . base_url() . 'notification/art-post/' . $total['art_post_id'] . '">    
                                                <div class="notification-pic" id="noti_pc">';

                        $filename = $this->config->item('art_profile_thumb_upload_path') . $total['user_image'];
                        $s3 = new S3(awsAccessKey, awsSecretKey);
                        $filepath = $s3->getObjectInfo(bucket, $filename);

                        
                        if ($total['user_image'] && $filepath) {
                            $return_html .= '<img src="' . ART_PROFILE_THUMB_UPLOAD_URL . $total['user_image'] . '" alt="'.$total['user_image'].'">';
                        } else {
                            $return_html .= '<img src = "' . base_url(NOARTIMAGE) . '" alt = "noimage">';
                        }
                        $return_html .= '</div>
                                                
                                                <div class="notification-data-inside" id="notification_inside">
                                                    <h6><b>' . '  ' . ucwords($total['first_name']) . ' ' . ucwords($total['last_name']) . '</b> Commented on your post in artistic profile.</h6>
                                                    <div  class="hout_noti">' .
                                $this->common->time_elapsed_string($total['not_created_date'], $full = false) .
                                '</div>
                                                </div>
                                            </a>    
                                            </li>';
                    }
                }


                // 4
                if ($total['not_from'] == 3) {
                    if ($total['not_img'] == 2) {

                        $return_html .= '<li class="';
                        if ($total['not_active'] == 1) {
                            $return_html .= 'active2';
                        } $return_html .= '">';
                        $return_html .= '<a href="' . base_url() . 'notification/art-post/' . $total['art_post_id'] . '">';
                        $return_html .= '<div class="notification-pic" id="noti_pc" >';

                        $filename = $this->config->item('art_profile_thumb_upload_path') . $total['user_image'];
                        $s3 = new S3(awsAccessKey, awsSecretKey);
                        $filepath = $s3->getObjectInfo(bucket, $filename);

                        if ($total['user_image'] && $filepath) {
                            $return_html .= '<img src="' . ART_PROFILE_THUMB_UPLOAD_URL . $total['user_image'] . '" alt="'.$total['user_image'].'">';
                        } else {
                            $return_html .= '<img src = "' . base_url(NOARTIMAGE) . '" alt = "noimage">';
                        }
                        $return_html .= '</div>
                                                
                                                <div class="notification-data-inside" id="notification_inside">
                                                    <h6><b>' . '  ' . ucwords($total['first_name']) . ' ' . ucwords($total['last_name']) . '</b> Likes your post in artistic profile.</h6>
                                                    <div  class="hout_noti">' .
                                $this->common->time_elapsed_string($total['not_created_date'], $full = false) .
                                '</div>
                                                </div>
                                              </a>  
                                            </li>';
                    }
                }




                //5
                if ($total['not_from'] == 3) {
                    if ($total['not_img'] == 3) {

                        $return_html .= '<li class="';
                        if ($total['not_active'] == 1) {
                            $return_html .= 'active2';
                        }
                        $return_html .= '"><a href="' . base_url() . 'notification/art-post/' . $total['art_post_id'] . '">
                                                <div class="notification-pic" id="noti_pc" >';

                        $filename = $this->config->item('art_profile_thumb_upload_path') . $total['user_image'];
                        $s3 = new S3(awsAccessKey, awsSecretKey);
                        $filepath = $s3->getObjectInfo(bucket, $filename);

                        if ($total['user_image'] && $filepath) {
                            $return_html .= '<img src="' . ART_PROFILE_THUMB_UPLOAD_URL . $total['user_image'] . '" alt="'.$total['user_image'].'">';
                        } else {
                            $return_html .= '<img src = "' . base_url(NOARTIMAGE) . '" alt = "noimage">';
                        }
                        $return_html .= '</div>
                                                
                                                <div class="notification-data-inside" id="notification_inside">
                                                    <h6><b>' . '  ' . ucwords($total['first_name']) . ' ' . ucwords($total['last_name']) . '</b> Likes your posts comment in artistic profile.</h6>
                                                  <div  class="hout_noti">' .
                                $this->common->time_elapsed_string($total['not_created_date'], $full = false) .
                                '</div>
                                                </div>
                                                </a>
                                            </li>';
                    }
                }


                //   6
                if ($total['not_from'] == 3) {
                    if ($total['not_img'] == 5) {
                        $return_html .= '<li class="';
                        if ($total['not_active'] == 1) {
                            $return_html .= 'active2';
                        } $return_html .= '"> <a href="' . base_url() . 'notification/art_post_img/' . $total['post_id'] . '/' . $total['post_files_id'] . '">';

                        $return_html .= '<div class="notification-pic"  id="noti_pc">';

                        $filename = $this->config->item('art_profile_thumb_upload_path') . $total['user_image'];
                        $s3 = new S3(awsAccessKey, awsSecretKey);
                        $filepath = $s3->getObjectInfo(bucket, $filename);

                        
                        if ($total['user_image'] && (file_exists($filepath)) == 1) {
                            $return_html .= '<img src="' . ART_PROFILE_THUMB_UPLOAD_URL . $total['user_image'] . '" alt="'.$total['user_image'].'">';
                        } else {
                            $return_html .= '<img src = "' . base_url(NOARTIMAGE) . '" alt = "noimage">';
                        }
                        $return_html .= '</div>
                                                
                                                <div class="notification-data-inside" id="notification_inside">
                                                    <h6><b>' . '  ' . ucwords($total['first_name']) . ' ' . ucwords($total['last_name']) . '</b> Likes your photo in artistic profile.</h6>
                                                    <div  class="hout_noti">' .
                                $this->common->time_elapsed_string($total['not_created_date'], $full = false) .
                                '</div>
                                                </div>
                                            </a>    
                                            </li>';
                    }
                }

//7
                if ($total['not_from'] == 3) {
                    if ($total['not_img'] == 4) {
                        $postid = $this->db->get_where('post_files', array('post_files_id' => $total['post_image_id']))->row()->post_id;
                        $return_html .= '<li class="';
                        if ($total['not_active'] == 1) {
                            $return_html .= 'active2';
                        } $return_html .= '"><a href="' . base_url() . 'notification/art_post_img/' . $postid . '/' . $total['post_image_id'] . '">
                                            <div class="notification-pic" id="noti_pc" >';

                        $filename = $this->config->item('art_profile_thumb_upload_path') . $total['user_image'];
                        $s3 = new S3(awsAccessKey, awsSecretKey);
                        $filepath = $s3->getObjectInfo(bucket, $filename);

                        if ($total['user_image'] && $filepath) {
                            $return_html .= '<img src="' . ART_PROFILE_THUMB_UPLOAD_URL . $total['user_image'] . '" alt="'.$total['user_image'].'">';
                        } else {
                            $return_html .= '<img src = "' . base_url(NOARTIMAGE) . '" alt = "noimage">';
                        }

                        $return_html .= '</div>
                                            
                                            <div class="notification-data-inside" id="notification_inside">
                                                <h6><b>' . '  ' . ucwords($total['first_name']) . ' ' . ucwords($total['last_name']) . '</b> Commneted on your photo in artistic profile.</h6>
                                                <div  class="hout_noti">'
                                . $this->common->time_elapsed_string($total['not_created_date'], $full = false) .
                                '</div>
                                            </div>
                                        </a>    
                                        </li>';
                    }
                }




                //   8
                if ($total['not_from'] == 3) {
                    if ($total['not_img'] == 6) {
                        $postid = $this->db->get_where('post_files', array('post_files_id' => $total['post_image_id']))->row()->post_id;
                        $return_html .= '<li class="';
                        if ($total['not_active'] == 1) {
                            $return_html .= 'active2';
                        } $return_html .= '">
                                            <a href="' . base_url() . 'notification/art_post_img/' . $postid . '/' . $total['post_image_id'] . '">
                                            <div class="notification-pic" id="noti_pc">';

                        $filename = $this->config->item('art_profile_thumb_upload_path') . $total['user_image'];
                        $s3 = new S3(awsAccessKey, awsSecretKey);
                        $filepath = $s3->getObjectInfo(bucket, $filename);

                        if ($total['user_image'] && $filepath) {
                            $return_html .= '<img src="' . ART_PROFILE_THUMB_UPLOAD_URL . $total['user_image'] . '" alt="'.$total['user_image'].'">';
                        } else {
                            $return_html .= '<img src = "' . base_url(NOARTIMAGE) . '" alt = "noimage">';
                        }
                        $return_html .= '</div>
                                            
                                            <div class="notification-data-inside" id="notification_inside">
                                                <h6><b>' . '  ' . ucwords($total['first_name']) . ' ' . ucwords($total['last_name']) . '</b> Likes your photos comment in artistic profile.</h6>
                                                <div  class="hout_noti">'
                                . $this->common->time_elapsed_string($total['not_created_date'], $full = false) .
                                '</div>
                                            </div>
                                            </a>
                                        </li>';
                    }
                }

                $bus_from1 = $total['not_from'];
                $bus_img1 = $total['not_img'];

                if ($bus_from1 == '6' && $bus_img1 == '1') {
                    $companyname = $this->db->get_where('business_profile', array('user_id' => $total['not_from_id']))->row()->company_name;

                    $return_html .= '<li class="';
                    if ($total['not_active'] == 1) {
                        $return_html .= 'active2';
                    } $return_html .= '"><a href="' . base_url() . 'notification/business-profile-post/' . $total['business_profile_post_id'] . '"  onClick="not_active(' . $total['not_id'] . ')">';

                    $return_html .= '<div class="notification-pic" id="noti_pc" >';

                    $filename = $this->config->item('bus_profile_thumb_upload_path') . $total['user_image'];
                         $s3 = new S3(awsAccessKey, awsSecretKey);
                         $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                      if ($total['user_image'] != '' && $info) { 
                    $return_html .= '<img src="' . BUS_PROFILE_THUMB_UPLOAD_URL . $total['user_image'] . '" alt="'.$total['user_image'].'" >';
                        } else {
                            $return_html .= '<img src = "' . base_url(NOBUSIMAGE2) . '" alt = "No Business Image">';
                        }
                    $return_html .= '</div>
                                            
                                            <div class="notification-data-inside" id="notification_inside">
                                                <h6><b>' . '  ' . ucwords($companyname) . '</b> Commented on your post in business profile.</h6>
                                              <div  class="hout_noti">'
                            . $this->common->time_elapsed_string($total['not_created_date'], $full = false) .
                            '</div>
                                            </div>
                                        </a></li>';
                }
                //10
                if ($total['not_from'] == 6) {
                    if ($total['not_img'] == 4) {
                        $postid = $this->db->get_where('post_files', array('post_files_id' => $total['post_image_id']))->row()->post_id;
                        $companyname = $this->db->get_where('business_profile', array('user_id' => $total['not_from_id']))->row()->company_name;
                        $return_html .= '<li class="';
                        if ($total['not_active'] == 1) {
                            $return_html .= 'active2';
                        } $return_html .= '"> <a href="' . base_url() . 'notification/business-profile-post-detail/' . $postid . '/' . $total['post_image_id'] . '">';

                        $return_html .= '<div class="notification-pic" id="noti_pc" >';
                       
                         $filename = $this->config->item('bus_profile_thumb_upload_path') . $total['user_image'];
                         $s3 = new S3(awsAccessKey, awsSecretKey);
                         $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                      if ($total['user_image'] != '' && $info) { 
                    $return_html .= '<img src="' . BUS_PROFILE_THUMB_UPLOAD_URL . $total['user_image'] . '" alt="'.$total['user_image'].'" >';
                        
                        } else {
                            $a = $companyname;
                            $acr = substr($a, 0, 1);


                            $return_html .= '<div class="post-img-div">' .
                                    ucwords($acr) .
                                    '</div>';
                        }
                        $return_html .= '</div>
                                            
                                            <div class="notification-data-inside" id="notification_inside">';
                        $return_html .= '<h6><b>' . '  ' . ucwords($companyname) . '</b> Commented on your photo in business profile.</h6>
                                                <div  class="hout_noti">'
                                . $this->common->time_elapsed_string($total['not_created_date'], $full = false) .
                                '</div>
                                            </div>
                        </a></li>';
                    }
                }


                //11
                if ($total['not_from'] == 6) {
                    if ($total['not_img'] == 6) {
                        $postid = $this->db->get_where('post_files', array('post_files_id' => $total['post_image_id']))->row()->post_id;
                        $companyname = $this->db->get_where('business_profile', array('user_id' => $total['not_from_id']))->row()->company_name;
                        $return_html .= '<li class="';
                        if ($total['not_active'] == 1) {
                            $return_html .= 'active2';
                        } $return_html .= '">';
                        $return_html .= '<a href="' . base_url() . 'notification/business-profile-post-detail/' . $postid . '/' . $total['post_image_id'] . '">';
                        $return_html .= '<div class="notification-pic" id="noti_pc" >';
                        $filename = $this->config->item('bus_profile_thumb_upload_path') . $total['user_image'];
                         $s3 = new S3(awsAccessKey, awsSecretKey);
                         $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                      if ($total['user_image'] != '' && $info) { 
                    $return_html .= '<img src="' . BUS_PROFILE_THUMB_UPLOAD_URL . $total['user_image'] . '" alt="'.$total['user_image'].'" >';
                        
                        } else {
                            $a = $companyname;
                            $acr = substr($a, 0, 1);


                            $return_html .= '<div class="post-img-div">' .
                                    ucwords($acr) .
                                    '</div>';
                        }
                        $return_html .= '</div>
                                            
                                            <div class="notification-data-inside" id="notification_inside">
                                                <h6><b>' . '  ' . ucwords($companyname) . '</b> Likes your photos comment in business profile.</h6>
                                               <div  class="hout_noti">' .
                                $this->common->time_elapsed_string($total['not_created_date'], $full = false) . '
                                                </div>
                                            </div>
                                            </a>
                                        </li>';
                    }
                }



                //12
                if ($total['not_from'] == 6 && $total['not_img'] == 0) {
                    $id = $this->db->get_where('business_profile', array('user_id' => $total['not_from_id']))->row()->business_slug;
                    $companyname = $this->db->get_where('business_profile', array('user_id' => $total['not_from_id']))->row()->company_name;
                    if ($id) {

                        $return_html .= '<li class="';
                        if ($total['not_active'] == 1) {
                            $return_html .= 'active2';
                        } $return_html .= '">';
                        $return_html .= '<a href="' . base_url() . 'business-profile/details/' . $id . '">';
                        $return_html .= '<div class="notification-pic" id="noti_pc" >';
                        $filename = $this->config->item('bus_profile_thumb_upload_path') . $total['user_image'];
                         $s3 = new S3(awsAccessKey, awsSecretKey);
                         $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                      if ($total['user_image'] != '' && $info) { 
                    $return_html .= '<img src="' . BUS_PROFILE_THUMB_UPLOAD_URL . $total['user_image'] . '" alt="'.$total['user_image'].'" >';
                        } else {

                            $return_html .= '<img src = "' . base_url(NOBUSIMAGE2) . '" alt = "No Business Image">';
                        }

                        $return_html .= '</div>
                                               
                                                <div class="notification-data-inside" id="notification_inside">
                                                    <h6><b>' . '  ' . ucwords($companyname) . '</b> Started following you in business profile.</h6>
                                                  <div  class="hout_noti">' .
                                $this->common->time_elapsed_string($total['not_created_date'], $full = false) .
                                '</div>
                                                </div>
                                                </a>
                                           </li>';
                    }
                }


                //  13
                if ($total['not_from'] == 6) {
                    if ($total['not_img'] == 2) {
                        $companyname = $this->db->get_where('business_profile', array('user_id' => $total['not_from_id']))->row()->company_name;
                        $return_html .= '<li class="';
                        if ($total['not_active'] == 1) {
                            $return_html .= 'active2';
                        } $return_html .= '">';
                        $return_html .= '<a href="' . base_url() . 'notification/business-profile-post/' . $total['business_profile_post_id'] . '">';
                        $return_html .= '<div class="notification-pic" id="noti_pc">';
                        $filename = $this->config->item('bus_profile_thumb_upload_path') . $total['user_image'];
                         $s3 = new S3(awsAccessKey, awsSecretKey);
                         $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                      if ($total['user_image'] != '' && $info) { 
                    $return_html .= '<img src="' . BUS_PROFILE_THUMB_UPLOAD_URL . $total['user_image'] . '" alt="'.$total['user_image'].'" >';
                        } else {
                            $return_html .= '<img src = "' . base_url(NOBUSIMAGE2) . '" alt = "No Business Image">';
                        }
                        $return_html .= '</div>
                                                <div class="notification-data-inside" id="notification_inside">
                                                    <h6><b>' . '  ' . ucwords($companyname) . '</b> Likes your post in business profile.</h6>
                                                   <div  class="hout_noti">' .
                                $this->common->time_elapsed_string($total['not_created_date'], $full = false) .
                                '</div>
                                                </div>
                                                </a>
                                            </li>';
                    }
                }

                // 14
                if ($total['not_from'] == 6) {
                    if ($total['not_img'] == 3) {
                        $companyname = $this->db->get_where('business_profile', array('user_id' => $total['not_from_id']))->row()->company_name;

                        $return_html .= '<li class="';
                        if ($total['not_active'] == 1) {
                            $return_html .= 'active2';
                        } $return_html .= '">';
                        $return_html .= '<a href="' . base_url() . 'notification/business-profile-post/' . $total['business_profile_post_id'] . '">';
                        
                        $return_html .= '<div class="notification-pic" id="noti_pc">';
                         $filename = $this->config->item('bus_profile_thumb_upload_path') . $total['user_image'];
                         $s3 = new S3(awsAccessKey, awsSecretKey);
                         $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                      if ($total['user_image'] != '' && $info) { 
                    $return_html .= '<img src="' . BUS_PROFILE_THUMB_UPLOAD_URL . $total['user_image'] . '" alt="'.$total['user_image'].'" >';
                        } else {
                            $return_html .= '<img src = "' . base_url(NOBUSIMAGE2) . '" alt = "No Business Image">';
                        }
                        $return_html .= '</div>
                                                
                                                <div class="notification-data-inside" id="notification_inside">
                                                    <h6><b>' . '  ' . ucwords($companyname) . '</b> Likes your post\'s comment in business profile.</h6>
                                               <div  class="hout_noti">'
                                . $this->common->time_elapsed_string($total['not_created_date'], $full = false) .
                                '</div>
                                                </div>
                                                </a>
                                            </li>';
                    }
                }




                // 15
                if ($total['not_from'] == 6) {
                    if ($total['not_img'] == 5) {
                        $companyname = $this->db->get_where('business_profile', array('user_id' => $total['not_from_id']))->row()->company_name;

                        $return_html .= '<li class="';
                        if ($total['not_active'] == 1) {
                            $return_html .= 'active2';
                        } $return_html .= '">';
                        $return_html .= '<a href="' . base_url('notification/business-profile-post-detail/' . $total['post_id'] . '/' . $total['post_files_id']) . '">';
                        $return_html .= '<div class="notification-pic" id="noti_pc" >';
                         $filename = $this->config->item('bus_profile_thumb_upload_path') . $total['user_image'];
                         $s3 = new S3(awsAccessKey, awsSecretKey);
                         $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                      if ($total['user_image'] != '' && $info) { 
                    $return_html .= '<img src="' . BUS_PROFILE_THUMB_UPLOAD_URL . $total['user_image'] . '" alt="'.$total['user_image'].'" >';
                        } else {
                            $return_html .= '<img src = "' . base_url(NOBUSIMAGE2) . '" alt = "No Business Image">';
                        }
                        $return_html .= '</div>
                                                <div class="notification-data-inside" id="notification_inside">
                                                    <h6><b>' . '  ' . ucwords($companyname) . '</b> Likes your photo in business profile.</h6>
                                                 <div  class="hout_noti">'
                                . $this->common->time_elapsed_string($total['not_created_date'], $full = false) .
                                '</div>
                                                </div>
                                                </a>
                                            </li>';
                    }
                }

                //  17
                if ($total['not_from'] == 2) {

                    $id = $this->db->get_where('job_reg', array('user_id' => $total['not_to_id']))->row()->job_id;
                    if ($id) {
                        $job_slug = $this->db->get_where('job_reg', array('user_id' => $total['not_from_id']))->row()->slug;
                        $return_html .= '<li class="';
                        if ($total['not_active'] == 1) {
                            $return_html .= 'active2';
                        }
                        $return_html .= '"><a href="' . base_url() . 'job/resume/' . $job_slug . '?page=recruiter">
                                                <div class="notification-pic" id="noti_pc" >';
                          $filename = $this->config->item('job_profile_thumb_upload_path') . $total['user_image'];
                         $s3 = new S3(awsAccessKey, awsSecretKey);
                         $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                      if ($total['user_image'] != '' && $info) { 
                    $return_html .= '<img src="' . JOB_PROFILE_THUMB_UPLOAD_URL . $total['user_image'] . '" alt="'.$total['user_image'].'" >';
                        } else {
                            $a = $total['first_name'];
                            $b = $total['last_name'];
                            $acr = substr($a, 0, 1);
                            $bcr = substr($b, 0, 1);


                            $return_html .= '<div class="post-img-div">'
                                    . ucwords($acr) . ucwords($bcr) .
                                    '</div>';
                        }

                        $return_html .= '</div>
                                                <div class="notification-data-inside" id="notification_inside">
                                                    <h6><b><i> Job Seeker</i></font></b><b>' . '  ' . ucwords($total['first_name']) . ' ' . ucwords($total['last_name']) . '</b> Aplied on your job post.</h6>
                                                <div  class="hout_noti">' .
                                $this->common->time_elapsed_string($total['not_created_date'], $full = false) .
                                '</div>
                                                </div>
                                                </a>
                                            </li>';
                    }
                }


                if ($total['not_from'] == 5 && $total['not_type'] == 4) {
                    //    19
                    $slug = $this->db->select('freelancer_apply_slug')->get_where('freelancer_post_reg', array('user_id' => $total['user_id']))->row()->freelancer_apply_slug;
                    $return_html .= '<li class="';
                    if ($total['not_active'] == 1) {
                        $return_html .= 'active2';
                    } $return_html .= '">';
                    $return_html .= '<a href="' . base_url() . 'freelance-work/freelancer-details/' . $slug .'">';
                    
                    $return_html .= '<div class="notification-pic" id="noti_pc" >';
                                                               
                    $filename = $this->config->item('free_hire_profile_main_upload_path') . $total['user_image'];
                         $s3 = new S3(awsAccessKey, awsSecretKey);
                         $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                      if ($total['user_image'] != '' && $info) { 
                    $return_html .= '<img src="' . FREE_HIRE_PROFILE_MAIN_UPLOAD_URL . $total['user_image'] . '" alt="'.$total['user_image'].'" >';
                    } else {
                        $a = $total['first_name'];
                        $b = $total['last_name'];
                        $acr = substr($a, 0, 1);
                        $bcr = substr($b, 0, 1);


                        $return_html .= '<div class="post-img-div">' .
                                ucwords($acr) . ucwords($bcr) .
                                '</div>';
                    }
                    $return_html .= '</div>
                                                
                                                <div class="notification-data-inside" id="notification_inside">
                                                    <h6><font color="black"><b><i>Employer</i></font></b><b>' . '  ' . ucwords($total['first_name']) . ' ' . ucwords($total['last_name']) . '</b> Selected you for project.</h6>
                                                 <div  class="hout_noti">' .
                            $this->common->time_elapsed_string($total['not_created_date'], $full = false) .
                            '</div>
                                                </div>
                                                </a>
                                            </li>';
                }
                //20
                if ($total['not_from'] == 4) {
                    $apply_slug = $this->db->select('freelancer_apply_slug')->get_where('freelancer_post_reg', array('user_id' => $total['not_from_id']))->row()->freelancer_apply_slug;
                    $return_html .= '<li class="';
                    if ($total['not_active'] == 1) {
                        $return_html .= 'active2';
                    } $return_html .= '">
                        <a href="' . base_url() . 'freelance-work/freelancer-details/' . $apply_slug.'">
                                            <div class="notification-pic" id="noti_pc" >';
                                                             
                    $filename = $this->config->item('free_post_profile_main_upload_path') . $total['user_image'];
                         $s3 = new S3(awsAccessKey, awsSecretKey);
                         $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                      if ($total['user_image'] != '' && $info) { 
                    $return_html .= '<img src="' . FREE_POST_PROFILE_MAIN_UPLOAD_URL . $total['user_image'] . '" alt="'.$total['user_image'].'" >';
                    } else {
                        $a = $total['first_name'];
                        $b = $total['last_name'];
                        $acr = substr($a, 0, 1);
                        $bcr = substr($b, 0, 1);


                        $return_html .= '<div class="post-img-div">' .
                                ucwords($acr) . ucwords($bcr) .
                                '</div>';
                    }
                    $return_html .= '</div>
                                            
                                            <div class="notification-data-inside" id="notification_inside">
                                                <h6><font color="black"><b><i>Freelancer</i></font></b><b>' . '  ' . ucwords($total['first_name']) . ' ' . ucwords($total['last_name']) . '</b> Applied on your post.</h6>
                                             <div  class="hout_noti">' .
                            $this->common->time_elapsed_string($total['not_created_date'], $full = false) .
                            '</div>
                                            </div>
                                            </a>
                                        </li>';
                }
            }
        } else {
            $return_html .= '<div class="art-img-nn">
                                                <div class="art_no_post_img">

                                                    <img src="assets/img/icon_notification_big.png" alt="notification image">

                                                </div>
                                                <div class="art_no_post_text">No Notification Available. </div>
                                            </div>';
        }

        echo $return_html;
        //NOTIFICATION DATA END
    }

    public function business_home_follow_ignore() {
        $userid = $this->session->userdata('aileenuser');
        $business_profile_id = $this->db->get_where('business_profile', array('user_id' => $userid, 'status' => '1'))->row()->business_profile_id;
        $follow_to = $_POST['follow_to'];

        $insert_data['profile'] = '2';
        $insert_data['user_from'] = $business_profile_id;
        $insert_data['user_to'] = $follow_to;

        echo $insert_id = $this->common->insert_data_getid($insert_data, 'user_ignore');
    }

    public function business_profile_active_check() {
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
            redirect('business-profile/business-information-update', refresh);
        }

// IF USER DEACTIVE PROFILE THEN REDIRECT TO BUSINESS-PROFILE/INDEX UNTILL ACTIVE PROFILE END
// DEACTIVATE PROFILE END
    }

    // BUSIENSS PROFILE USER FOLLOWING COUNT START

    public function business_user_following_count($business_profile_id = '') {
        $userid = $this->session->userdata('aileenuser');
        if ($business_profile_id == '') {
            $business_profile_id = $this->db->get_where('business_profile', array('user_id' => $userid, 'status' => '1'))->row()->business_profile_id;
        }

        $contition_array = array('follow_from' => $business_profile_id, 'follow_status' => '1', 'follow_type' => '2', 'business_profile.status' => '1');

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
        $userid = $this->session->userdata('aileenuser');
        if ($business_profile_id == '') {
            $business_profile_id = $this->db->get_where('business_profile', array('user_id' => $userid, 'status' => '1'))->row()->business_profile_id;
        }

        $contition_array = array('follow_to' => $business_profile_id, 'follow_status' => '1', 'follow_type' => '2', 'business_profile.status' => '1');

        $join_str_following[0]['table'] = 'follow';
        $join_str_following[0]['join_table_id'] = 'follow.follow_from';
        $join_str_following[0]['from_table_id'] = 'business_profile.business_profile_id';
        $join_str_following[0]['join_type'] = '';

        $bus_user_f_er_count = $this->common->select_data_by_condition('business_profile', $contition_array, $data = 'count(*) as follower_count', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str_following, $groupby = '');

        $follower_count = $bus_user_f_er_count[0]['follower_count'];

        return $follower_count;
    }

    // BUSIENSS PROFILE USER FOLLOWER COUNT END
    // 
    public function business_user_contacts_count($business_profile_id = '') {

        $userid = $this->session->userdata('aileenuser');
        if ($business_profile_id != '') {
            $userid = $this->db->get_where('business_profile', array('business_profile_id' => $business_profile_id, 'status' => '1'))->row()->user_id;
        }

        $contition_array = array('contact_type' => '2', 'contact_person.status' => 'confirm', 'business_profile.status' => '1');
        $search_condition = "((contact_from_id = ' $userid') OR (contact_to_id = '$userid'))";

        $join_str_contact[0]['table'] = 'business_profile';
        $join_str_contact[0]['join_table_id'] = 'business_profile.user_id';
        $join_str_contact[0]['from_table_id'] = 'contact_person.contact_from_id';
        $join_str_contact[0]['join_type'] = '';

        $contacts_count = $this->common->select_data_by_search('contact_person', $search_condition, $contition_array, $data = 'count(*) as contact_count', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str_contact, $groupby = '');

        $contacts_count = $contacts_count[0]['contact_count'];

        return $contacts_count;
    }

    // for artistic url start function
    public function get_url($userid) {

        $contition_array = array('user_id' => $userid, 'status' => '1');
        $arturl = $this->common->select_data_by_condition('art_reg', $contition_array, $data = 'art_id,art_city,art_skill,other_skill,slug', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $city_url = $this->db->select('city_name')->get_where('cities', array('city_id' => $arturl[0]['art_city'], 'status' => '1'))->row()->city_name;

        $art_othercategory = $this->db->select('other_category')->get_where('art_other_category', array('other_category_id' => $arturl[0]['other_skill']))->row()->other_category;

        $category = $arturl[0]['art_skill'];
        $category = explode(',', $category);

        foreach ($category as $catkey => $catval) {
            $art_category = $this->db->select('art_category')->get_where('art_category', array('category_id' => $catval))->row()->art_category;
            $categorylist[] = $art_category;
        }

        $listfinal1 = array_diff($categorylist, array('other'));
        $listFinal = implode('-', $listfinal1);

        if (!in_array(26, $category)) {
            $category_url = $this->common->clean($listFinal);
        } else if ($arturl[0]['art_skill'] && $arturl[0]['other_skill']) {

            $trimdata = $this->common->clean($listFinal) . '-' . $this->common->clean($art_othercategory);
            $category_url = trim($trimdata, '-');
        } else {
            $category_url = $this->common->clean($art_othercategory);
        }

        $city_get = $this->common->clean($city_url);

        $url = $arturl[0]['slug'] . '-' . $category_url . '-' . $city_get . '-' . $arturl[0]['art_id'];
        return $url;
    }

}
