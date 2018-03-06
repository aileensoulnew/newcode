<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Blog_Model extends CI_Model {

    public static $category = "blog_category";
    public static $blog = "blog";

    public function CategoryOnly() {
        $this->db->where('parent_id', '0');
        $results = $this->db->get('category')->result();
        return $results;
    }

    public function Blogdetail($is_not = null) {
        if (isset($is_not) && $is_not != "" && $is_not != null) {
            $this->db->where('blog_id', $is_not);
        }
        $get = $this->db->get('blog');
        return $get->result();
    }

    public function Blogcount($is_not = null) {
        if (isset($is_not) && $is_not != "" && $is_not != null) {
            $this->db->where('blog_id', $is_not);
            $this->db->where('approve_status', '1');
        }
        $get = $this->db->get('blog_review');
        return $get->result();
    }

    public function AllBlog() {

        $get = $this->db->get('blog');
        return $get->result();
    }

    public function Oldblog() {
        $this->db->limit($limit = '5', $offset = "0");
        $this->db->order_by('blog_id', "desc");
        $get = $this->db->get('blog');
        return $get->result();
    }

    public function Oldblogdetail($is_not = null) {
        $this->db->limit($limit = '5', $offset = "0");
        $this->db->order_by('blog_id', "desc");
        if (isset($is_not) && $is_not != "" && $is_not != null) {
            $this->db->where('blog_id !=', $is_not);
        }
        $get = $this->db->get('blog');
        return $get->result();
    }

}
