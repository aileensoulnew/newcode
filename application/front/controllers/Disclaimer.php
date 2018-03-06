<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Disclaimer extends CI_Controller {

    public function __construct() {
        parent::__construct();
        //AWS access info start
        $this->load->library('S3');
        //AWS access info end
        include ('include.php');
    }

    public function index() {
        $this->data['title'] = 'Disclaimer Policy - Aileensoul';
        $this->data['login_header'] = $this->load->view('login_header', $this->data,TRUE);
        $this->data['login_footer'] = $this->load->view('login_footer', $this->data,TRUE);
        $this->load->view('disclaimerpolicy', $this->data);
    }

}
