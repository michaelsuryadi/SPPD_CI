<?php

class Org extends CI_Controller {
    public function __construct() {
        parent::__construct();
    }
    
    function index(){
        $data['title'] = 'List Organization';
        $data['result'] = $this->get_session();
        $data['app_config'] = $this->admin_config->load_app_config();
        $data['mid_content'] = 'content/organization/list_org';
        $this->load->view('includes/home_template',$data);
    }
    
    function get_session(){
        $this->load->model('employee');
        $username = $this->session->userdata('username');
        $data['result'] = $this->employee->get_detail_emp($username);
        return $data['result'];
    }
    
    function add_org(){
        $data['title'] = 'Add Organization';
        $data['result'] = $this->get_session();
        $data['app_config'] = $this->admin_config->load_app_config();
        $data['mid_content'] = 'content/organization/add_org';
        $this->load->view('includes/home_template',$data);
    }
}
