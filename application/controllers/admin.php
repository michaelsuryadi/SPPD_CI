<?php

class Admin extends CI_Controller{
    
    public function __construct() {
        parent::__construct();
    }
    
    function index(){
        $data['title'] = 'Admin Config';
        $data['mid_content'] = 'content/admin/admin_config';
        $this->load->model('employee');
        $data['employees'] = $this->employee->get_all_emp();
        
        $this->load->model('admin_config');
        $data['config'] = $this->admin_config->load_config_data();
        
        $username = $this->session->userdata('username');
        $data['result'] = $this->employee->get_detail_emp($username);
        $this->load->view('includes/home_template', $data);
    }
    
    function upd_config(){
        $this->load->model('admin_config');
        $q = $this->admin_config->upd_config_data();
        
        if($q){
            redirect("admin");
        }
    }
    
    
}
