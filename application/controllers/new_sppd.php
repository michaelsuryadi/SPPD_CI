<?php

class New_sppd extends CI_Controller{
    
    public function __construct() {
        parent::__construct();
    }
    
    function index(){
        $this->load->model('employee');
        $username = $this->session->userdata('username');
        $data['result'] = $this->employee->get_detail_emp($username);
        $data['title'] = 'Input SPPD';
        $data['mid_content']='content/new_sppd/create';
        $this->load->view('includes/home_template',$data);
    }
}
