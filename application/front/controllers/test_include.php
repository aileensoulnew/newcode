<?php
// user detail


$this->data['test_header'] = $this->load->view('test/form_header', $this->data, true);

$this->data['test_footer'] = $this->load->view('test/form_footer', $this->data, true);


$slug = $this->uri->segment(3);

