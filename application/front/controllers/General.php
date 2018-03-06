<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class General extends MY_Controller {

    public $data;

    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
// if ($this->session->userdata('aileensoul_front') == '') {
//             redirect('login', 'refresh');
//         }
        //AWS access info start
        $this->load->library('S3');
        //AWS access info end
        include ('include.php');
    }

    public function get_location($id = "") {


        //get search term
        $searchTerm = $_GET['term'];
        if (!empty($searchTerm)) {

            $contition_array = array('state_id !=' => '0', 'status' => '1');
            $search_condition = "(city_name LIKE '" . trim($searchTerm) . "%')";
            $citylist = $this->common->select_data_by_search('cities', $search_condition, $contition_array, $data = 'city_id as id,city_name as text', $sortby = 'city_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str5 = '', $groupby = 'city_name');
            
            $contition_array = array('country_id !=' => '0', 'status' => '1');
            $search_condition = "(country_name LIKE '" . trim($searchTerm) . "%')";
            $countrylist = $this->common->select_data_by_search('countries', $search_condition, $contition_array, $data = 'country_id as id,country_name as text', $sortby = 'country_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str5 = '', $groupby = 'country_name');
        }
        $unique = array_merge((array) $citylist, (array) $countrylist);
        foreach ($unique as $key => $value) {
          
            $palcedata[$key]['value'] = $value['text'];
        }

        $cdata = array_values($palcedata);
        echo json_encode($cdata);
    }

    public function get_skill($id = "") {

        //get search term
        $searchTerm = $_GET['term'];
        if (!empty($searchTerm)) {
            $contition_array = array('status' => '1', 'type' => '1');
            $search_condition = "(skill LIKE '" . trim($searchTerm) . "%')";
            $citylist = $this->common->select_data_by_search('skill', $search_condition, $contition_array, $data = 'skill as text', $sortby = 'skill', $orderby = 'desc', $limit = '', $offset = '', $join_str5 = '', $groupby = 'skill');
        }
        foreach ($citylist as $key => $value) {
            //   $citydata[$key]['id'] = $value['id'];
            $citydata[$key]['value'] = $value['text'];
        }

        $cdata = array_values($citydata);
        echo json_encode($cdata);
    }

    public function get_artskill($id = "") {

        //get search term
        $searchTerm = $_GET['term'];
        if (!empty($searchTerm)) {
            $contition_array = array('status' => '1', 'type' => '2');
            $search_condition = "(skill LIKE '" . trim($searchTerm) . "%')";
            $citylist = $this->common->select_data_by_search('skill', $search_condition, $contition_array, $data = 'skill as text', $sortby = 'skill', $orderby = 'desc', $limit = '', $offset = '', $join_str5 = '', $groupby = 'skill');
        }
        foreach ($citylist as $key => $value) {
            //   $citydata[$key]['id'] = $value['id'];
            $citydata[$key]['value'] = $value['text'];
        }

        $cdata = array_values($citydata);
        echo json_encode($cdata);
    }

    public function get_language($id = "") {

        //get search term
        $searchTerm = $_GET['term'];
        if (!empty($searchTerm)) {
            $contition_array = array('status' => '1');
            $search_condition = "(language_name LIKE '" . trim($searchTerm) . "%')";
            $languagelist = $this->common->select_data_by_search('language', $search_condition, $contition_array, $data = 'language_name as text', $sortby = 'language_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str5 = '', $groupby = 'language_name');
        }
        foreach ($languagelist as $key => $value) {
            //   $citydata[$key]['id'] = $value['id'];
            $languagedata[$key]['value'] = $value['text'];
        }

        $cdata = array_values($languagedata);
        echo json_encode($cdata);
    }

    public function get_jobtitle($id = "") {


        //get search term
        $searchTerm = $_GET['term'];
        if (!empty($searchTerm)) {

            $contition_array = array('status' => 'publish');
            $search_condition = "(name LIKE '" . trim($searchTerm) . "%')";
            $jobtitlelist = $this->common->select_data_by_search('job_title', $search_condition, $contition_array, $data = 'title_id as id,name as text', $sortby = 'name', $orderby = 'desc', $limit = '', $offset = '', $join_str5 = '', $groupby = 'name');
        }
        foreach ($jobtitlelist as $key => $value) {
            //   $citydata[$key]['id'] = $value['id'];
            $jobtitledata[$key]['value'] = $value['text'];
        }

        $cdata = array_values($jobtitledata);
        echo json_encode($cdata);
    }

    // DEGREE DATA START
    public function get_degree($id = "") {

        $userid = $this->session->userdata('aileenuser');
        //get search term
        $searchTerm = $_GET['term'];
        if (!empty($searchTerm)) {

            $contition_array = array('is_delete' => '0', 'degree_name !=' => "Other");
            $search_condition = "((status = '2' AND user_id = $userid) OR (status = '1')) AND (degree_name LIKE '" . trim($searchTerm) . "%')";
            $degree = $this->data['degree'] = $this->common->select_data_by_search('degree', $search_condition, $contition_array, $data = 'degree_name as text', $sortby = 'degree_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        }
        foreach ($degree as $key => $value) {
            //   $citydata[$key]['id'] = $value['id'];
            $degreedata[$key]['value'] = $value['text'];
        }

        $cdata = array_values($degreedata);
        echo json_encode($cdata);
    }

    // DEGREE DATA END
}
