<?php

class View_sppd extends CI_Controller{
    
    public function __construct() {
        parent::__construct();
    }
    
    function index(){
        $this->load->model('employee');
        $username = $this->session->userdata('username');
        $data['result'] = $this->employee->get_detail_emp($username);
        $data['title'] = 'View SPPD';
        $data['mid_content']='content/process_sppd/view_sppd';
        $this->load->view('includes/home_template',$data);
    }
}
