<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Job_model extends CI_Model {

    public function isJobAvailable($user_id = '') {
        $this->db->select("count(*) as total")->from("job_reg j");
        $this->db->where(array('j.user_id' => $user_id, 'j.status' => '1', 'j.is_delete' => '0', 'j.job_step' => '10'));
        $query = $this->db->get();
        $result_array = $query->row_array();
        return $result_array;
    }

    function jobCategory($limit = '') {
        $this->db->select('count(rp.post_id) as count,ji.industry_id,ji.industry_name,ji.industry_slug')->from('job_industry ji');
        $this->db->join('rec_post rp', 'rp.industry_type = ji.industry_id', 'left');
        $this->db->where('ji.status', '1');
        $this->db->where('ji.is_delete', '0');
        $this->db->where('rp.status', '1');
        $this->db->where('rp.is_delete', '0');
        $this->db->group_by('rp.industry_type');
        $this->db->order_by('count', 'desc');
        $this->db->limit($limit);
        $query = $this->db->get();
        $result_array = $query->result_array();
        return $result_array;
    }

    function jobCity($limit = '') {
        $this->db->select('count(rp.post_id) as count,c.city_id,c.city_name,c.slug')->from('cities c');
        $this->db->join('rec_post rp', 'rp.city = c.city_id', 'left');
        $this->db->where('c.status', '1');
        $this->db->where('rp.status', '1');
        $this->db->where('rp.is_delete', '0');
        $this->db->group_by('rp.city');
        $this->db->order_by('count', 'desc');
        $this->db->limit($limit);
        $query = $this->db->get();
        $result_array = $query->result_array();
        return $result_array;
    }

    function jobCompany($limit = '') {
        $this->db->select('count(rp.user_id) as count,r.user_id,r.rec_id, r.re_comp_name as company_name')->from('recruiter r');
        $this->db->join('rec_post rp', 'rp.user_id = r.user_id', 'left');
        $this->db->where('r.re_status', '1');
        $this->db->where('rp.status', '1');
        $this->db->where('rp.is_delete', '0');
        $this->db->group_by('rp.user_id');
        $this->db->order_by('count', 'desc');
        $this->db->limit($limit);
        $query = $this->db->get();
        $result_array = $query->result_array();
        return $result_array;
    }

    function jobSkill($limit = '') {
        /*    $this->db->select('count(rp.user_id) as count,s.skill_id,s.skill,s.skill_slug')->from('skill s');
          $this->db->join('rec_post rp', 'rp.user_id = r.user_id', 'left');
          $this->db->where('FIND_IN_SET(ar.art_skill, ' . $category_id . ')');
          $this->db->where('s.type', '1');
          $this->db->where('s.status', '1');
          $this->db->where('rp.is_delete', '0');
          $this->db->group_by('rp.user_id');
          $this->db->order_by('count', 'desc');
          $this->db->limit($limit);
          $query = $this->db->get();
          $result_array = $query->result_array();
          return $result_array; */

        $this->db->select('s.skill_id,s.skill,s.skill_slug')->from('skill s');
        $this->db->where('s.status', '1');
        $this->db->where('s.type', '1');
        $query = $this->db->get();
        $art_category = $query->result_array();
        $return_array = array();
        foreach ($art_category as $key => $value) {
            $return = array();
            $skill_id = $value['skill_id'];
            $this->db->select('count(post_id) as count')->from('rec_post rp');
            $this->db->where('FIND_IN_SET(rp.post_skill, ' . $skill_id . ')');
            $this->db->where('rp.status', '1');
            $this->db->where('rp.is_delete', '0');
            $query = $this->db->get();
            $cat_count = $query->row_array();

            $return['count'] = $cat_count['count'];
            $return['skill_id'] = $value['skill_id'];
            $return['skill'] = $value['skill'];
            $return['skill_slug'] = $value['skill_slug'];

            array_push($return_array, $return);
        }
        array_multisort(array_column($return_array, 'count'), SORT_DESC, $return_array);
        array_splice($return_array, $limit);

        return $return_array;
    }

    function latestJob() {
        $this->db->select("rp.post_id,rp.post_name,jt.name as string_post_name,rp.post_description,DATE_FORMAT(rp.created_date,'%d-%M-%Y') as created_date,ct.city_name,cr.country_name,rp.min_year,rp.max_year,rp.fresher,CONCAT(r.rec_firstname,' ',r.rec_lastname) as fullname, r.re_comp_name,r.comp_logo")->from('rec_post rp');
        $this->db->join('recruiter r', 'r.user_id = rp.user_id', 'left');
        $this->db->join('cities ct', 'ct.city_id = rp.city', 'left');
        $this->db->join('countries cr', 'cr.country_id = rp.country', 'left');
        $this->db->join('job_title jt', 'jt.title_id = rp.post_name', 'left');
        $this->db->where('rp.status', '1');
        $this->db->where('rp.is_delete', '0');
        $this->db->order_by('rp.post_id', 'desc');
        $query = $this->db->get();
        $result_array = $query->result_array();
        return $result_array;
    }

    function applyJobFilter($posting_period = '', $experience = '', $category = '', $location = '', $company = '', $skill = '') {
//        echo $posting_period;
//        echo '<br>';
//        echo $experience;
//        echo '<br>';
//        echo $category;
//        echo '<br>';
//        echo $location;
//        echo '<br>';
//        echo $company;
//        echo '<br>';
//        echo $skill;


        $this->db->select("rp.post_id,rp.post_name,jt.name as string_post_name,rp.post_description,DATE_FORMAT(rp.created_date,'%d-%M-%Y') as created_date,ct.city_name,cr.country_name,rp.min_year,rp.max_year,rp.fresher,CONCAT(r.rec_firstname,' ',r.rec_lastname) as fullname, r.re_comp_name,r.comp_logo")->from('rec_post rp');
        $this->db->join('recruiter r', 'r.user_id = rp.user_id', 'left');
        $this->db->join('cities ct', 'ct.city_id = rp.city', 'left');
        $this->db->join('countries cr', 'cr.country_id = rp.country', 'left');
        $this->db->join('job_title jt', 'jt.title_id = rp.post_name', 'left');
        if ($posting_period != '') {
            $posting_period = explode(',', $posting_period);
            $posting_where = '(';
            foreach ($posting_period as $key => $value) {
                if ($value == '1') {
                    $select_date1 = date('Y-m-d');
                    $posting_where1 .= "rp.created_date = '$select_date1' OR";
                } elseif ($value == '2') {
                    $select_date2 = date('Y-m-d', strtotime('-7 days'));
                    $posting_where1 .= " rp.created_date >= '$select_date2' OR";
                } elseif ($value == '3') {
                    $select_date3 = date('Y-m-d', strtotime('-15 days'));
                    $posting_where1 .= " rp.created_date >= '$select_date3' OR";
                } elseif ($value == '4') {
                    $select_date4 = date('Y-m-d', strtotime('-45 days'));
                    $posting_where1 .= " rp.created_date >= '$select_date4' OR";
                } elseif ($value == '5') {
                    $select_date5 = date('Y-m-d', strtotime('-45 days'));
                    $posting_where1 .= " rp.created_date <= '$select_date5'";
                }
            }
            $posting_where .= trim($posting_where1, 'OR');
            $posting_where .= ')';
        }
        if ($posting_where) {
            $this->db->where($posting_where);
        }
        if ($experience != '') {
            $experience = explode(',', $experience);
            $exp_where = '(';
            foreach ($experience as $key => $value) {
                if ($value == '1') {
                    $select_min = '0';
                    $select_max = '1';
                    $select_date1 = date('Y-m-d');
                    $exp_where1 .= " (rp.min_year = '$select_min' AND rp.max_year = '$select_max') OR";
                } elseif ($value == '2') {
                    $select_min = '1';
                    $select_max = '2';
                    $select_date2 = date('Y-m-d', strtotime('-7 days'));
                    $exp_where1 .= " (rp.min_year = '$select_min' AND rp.max_year = '$select_max') OR";
                } elseif ($value == '3') {
                    $select_min = '2';
                    $select_max = '3';
                    $select_date3 = date('Y-m-d', strtotime('-15 days'));
                    $exp_where1 .= " (rp.min_year = '$select_min' AND rp.max_year = '$select_max') OR";
                } elseif ($value == '4') {
                    $select_min = '3';
                    $select_max = '4';
                    $select_date4 = date('Y-m-d', strtotime('-45 days'));
                    $exp_where1 .= " (rp.min_year = '$select_min' AND rp.max_year = '$select_max') OR";
                } elseif ($value == '5') {
                    $select_min = '4';
                    $select_max = '5';
                    $select_date5 = date('Y-m-d', strtotime('-45 days'));
                    $exp_where1 .= " (rp.min_year = '$select_min' AND rp.max_year = '$select_max') OR";
                } else {
                    $exp_where1 .= "(rp.min_year <= '5'";
                }
            }
            $exp_where .= trim($exp_where1, 'OR');
            $exp_where .= ')';
        }
        if ($exp_where) {
            $this->db->where($exp_where);
        }

        if ($category != '') {
            $category = str_replace(",", "','", $category);
            $cat_where = "(rp.industry_type IN ('$category'))";
        }
        if ($cat_where) {
            $this->db->where($cat_where);
        }
        if ($skill != '') {
            $skill = explode(',', $skill);
            $skill_where = '(';
            foreach ($skill as $key => $value) {
                $skill_where1 .= ' FIND_IN_SET(rp.post_skill, ' . $value . ') OR';
            }
            $skill_where .= trim($skill_where1, 'OR');
            $skill_where .= ')';
        }
        if ($skill_where) {
            $this->db->where($skill_where);
        }
        if ($location != '') {
            $location = str_replace(",", "','", $location);
            $loc_where = "(rp.city IN ('$location'))";
        }
        if ($loc_where) {
            $this->db->where($loc_where);
        }
        if ($company != '') {
            $company = str_replace(",", "','", $company);
            $com_where = "(rp.user_id IN ('$company'))";
        }
        if ($com_where) {
            $this->db->where($com_where);
        }
        $this->db->where('rp.status', '1');
        $this->db->where('rp.is_delete', '0');
        $this->db->order_by('rp.post_id', 'desc');
        $query = $this->db->get();
        $result_array = $query->result_array();

        return $result_array;
    }

    function findJobCategory($keyword = '') {
        $this->db->select('industry_id')->from('job_industry ji');
        if ($keyword != '') {
            $this->db->where("(ji.industry_name LIKE '%$keyword%')");
        }
        $this->db->where('ji.status', '1');
        $this->db->where('ji.is_delete', '0');
        $query = $this->db->get();
        $result_array = $query->row_array();
        return $result_array['industry_id'];
    }

    function findJobSkill($keyword = '') {
        $this->db->select('skill_id')->from('skill s');
        if ($keyword != '') {
            $this->db->where("(s.skill LIKE '%$keyword%')");
        }
        $this->db->where('s.status', '1');
        $query = $this->db->get();
        $result_array = $query->row_array();
        return $result_array['skill_id'];
    }

    function searchJobData($keyword = '', $location = '', $work = '') {
        $keyword = str_replace('%20', ' ', $keyword);
        $location = str_replace('%20', ' ', $location);
        $work = str_replace('%20', ' ', $work);
        $work = explode(' ', $work);

        $jobCat = $this->findJobCategory($keyword);
        $jobSkill = $this->findJobSkill($keyword);

        $this->db->select("rp.post_id,rp.post_name,jt.name as string_post_name,rp.post_description,DATE_FORMAT(rp.created_date,'%d-%M-%Y') as created_date,ct.city_name,cr.country_name,rp.min_year,rp.max_year,rp.fresher,CONCAT(r.rec_firstname,' ',r.rec_lastname) as fullname, r.re_comp_name,r.comp_logo")->from('rec_post rp');
        $this->db->join('recruiter r', 'r.user_id = rp.user_id', 'left');
        $this->db->join('cities ct', 'ct.city_id = rp.city', 'left');
        $this->db->join('countries cr', 'cr.country_id = rp.country', 'left');
        $this->db->join('states s', 's.state_name = rp.state', 'left');
        $this->db->join('job_title jt', 'jt.title_id = rp.post_name', 'left');
        if ($keyword != '' && $jobCat == '' && $jobSkill == '') {
            $this->db->where("(rp.post_name LIKE '%$keyword%' OR jt.name LIKE '%$keyword%' OR rp.post_description LIKE '%$keyword%' OR rp.min_year LIKE '%$keyword%' OR rp.max_year LIKE '%$keyword%' OR r.re_comp_name LIKE '%$keyword%' OR r.rec_firstname LIKE '%$keyword%' OR r.rec_lastname LIKE '%$keyword%' OR rp.other_skill LIKE '%$keyword%')");
        } elseif ($keyword != '' && $jobCat != '' && $jobSkill == '') {
            $this->db->where("(rp.post_name LIKE '%$keyword%' OR jt.name LIKE '%$keyword%' OR rp.post_description LIKE '%$keyword%' OR rp.min_year LIKE '%$keyword%' OR rp.max_year LIKE '%$keyword%' OR r.re_comp_name LIKE '%$keyword%' OR r.rec_firstname LIKE '%$keyword%' OR r.rec_lastname LIKE '%$keyword%' OR rp.other_skill LIKE '%$keyword%' OR rp.industry_type = '$jobCat')");
        } elseif ($keyword != '' && $jobCat != '' && $jobSkill != '') {
            $this->db->where("(rp.post_name LIKE '%$keyword%' OR jt.name LIKE '%$keyword%' OR rp.post_description LIKE '%$keyword%' OR rp.min_year LIKE '%$keyword%' OR rp.max_year LIKE '%$keyword%' OR r.re_comp_name LIKE '%$keyword%' OR r.rec_firstname LIKE '%$keyword%' OR r.rec_lastname LIKE '%$keyword%' OR rp.other_skill LIKE '%$keyword%' OR rp.industry_type = '$jobCat'  OR FIND_IN_SET(rp.post_skill, '$jobSkill'))");
        }
        if ($work[0] != '') {
            $work_where = '(';
            foreach ($work as $key => $value) {
                if ($value == 'fulltime') {
                    $value = 'Full Time';
                } else if ($value == 'parttime') {
                    $value = 'Part Time';
                } else if ($value == 'internship') {
                    $value = 'Internship';
                }
                $work_where1 .= " rp.emp_type ='$value' OR";
            }
            $work_where .= trim($work_where1, 'OR');
            $work_where .= ')';
        }
        if ($work_where) {
            $this->db->where($work_where);
        }
        if ($location != '') {
            $this->db->where("(ct.city_name = '$location' OR cr.country_name = '$location' OR s.state_name = '$location')");
        }
        $this->db->where('rp.status', '1');
        $this->db->where('rp.is_delete', '0');
        $this->db->order_by('rp.post_id', 'desc');
        $query = $this->db->get();
        $result_array = $query->result_array();
        return $result_array;
    }

}
