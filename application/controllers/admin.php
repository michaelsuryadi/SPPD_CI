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
        $data['app_config'] = $this->admin_config->load_app_config();
        
        $username = $this->session->userdata('username');
        $data['result'] = $this->employee->get_detail_emp($username);
        $this->load->view('includes/home_template', $data);
    }
    
    /*
     * Function untuk menyimpan update dari config
     */
    function upd_config(){
        $this->load->model('admin_config');
        $q = $this->admin_config->upd_config_data();
        
        if($q){
            redirect("admin");
        }
    }
    
    function fiatur_config(){
        $data['title'] = 'Fiatur Config';
        $data['mid_content'] = 'content/admin/config_fiatur';
        $this->load->model('employee');
        $data['employees'] = $this->employee->get_all_emp();
        
        $this->load->model('admin_config');
        $this->load->model('organization');
        $data['app_config'] = $this->admin_config->load_app_config();
        $data['org'] = $this->organization->get_all_org();
        
        $username = $this->session->userdata('username');
        $data['result'] = $this->employee->get_detail_emp($username);
        $this->load->view('includes/home_template', $data);
        
    }
    
    
}
