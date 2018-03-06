<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Userslug extends MY_Controller {

    public $data;

    public function __construct() {

        parent::__construct();
        $this->load->model('email_model');
        $this->load->library('S3');
        $this->data['title'] = "Grow Business Network | Hiring | Search Jobs | Freelance Work | Artistic | It's Free";
       
        //This function is there only one time users slug created after remove it start
//         $this->db->select('user_id,first_name,last_name');
//         $res = $this->db->get('user')->result();
//         foreach ($res as $k => $v) {
//             $data = array('user_slug' => $this->setuser_slug($v->first_name."-". $v->last_name, 'user_slug', 'user'));
//             $this->db->where('user_id', $v->user_id);
//             $this->db->update('user', $data);
//          }
//        //This function is there only one time users slug created after remove it End
        
        include('include.php');
    }

    public function index($id = " ") {
    
    }
    
     public function user_slug() { 
               $this->db->select('user_id,first_name,last_name');
         $res = $this->db->get('user')->result();
         foreach ($res as $k => $v) {
             $data = array('user_salug' => '');
             $this->db->where('user_id', $v->user_id);
              $this->db->update('user', $data);
          }
          
          
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
