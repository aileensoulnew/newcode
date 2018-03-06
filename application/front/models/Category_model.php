<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category_Model extends CI_Model {

    public static $category_groups_table = "category_groups";
    public static $category_table = "category";

	public function CategoryOnly(){
		$this->db->where('parent_id', '0');
		$results = $this->db->get('category')->result();
		return $results;
	}

	public function AllCategory($is_not = null){
		if(isset($is_not) && $is_not != "" && $is_not != null){
			$this->db->where('cate_id !=', $is_not);
		}
		$get = $this->db->get('category');
		return $get->result();
	}

	public function geCatetoSub($parent_id){
		$this->db->where('parent_id', $parent_id);
		$get = $this->db->get('category');
		return $get->result();
	}

	public function CategoryGroup($cate_id){
        return $this->db->select('category_group_name,catg_id,category_id,subcategory_id')->where('category_id',$cate_id)->get(self::$category_groups_table)->result();
    }

    public function getCategoryID($id){
        return $this->db->select('category_name,category_slug,cate_id')->where('cate_id',$id)->get(self::$category_table)->row();
    }
	

}