<?php

class Utilities extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    function change_password_view() {
        $data['title'] = "Change Password";
        $data['mid_content'] = 'content/utilities/change_password';
        $this->load->model('employee');
        $data['employees'] = $this->employee->get_all_emp();
        $username = $this->session->userdata('username');
        $data['result'] = $this->employee->get_detail_emp($username);
        $this->load->view('includes/home_template', $data);
    }
    
    function process_change_password(){
        $this->load->model('utility_model');
        $query = $this->utility_model->process_change_password();
        
        if($query) {
            redirect('/site');
        }
        else {
            redirect('/utilities/change_password_view');
        }
    }
    
    function help_view(){
        $data['title'] = "Help";
        $data['mid_content'] = 'content/utilities/help';
        $this->load->model('employee');
        $data['employees'] = $this->employee->get_all_emp();
        $username = $this->session->userdata('username');
        $data['result'] = $this->employee->get_detail_emp($username);
        $this->load->view('includes/home_template', $data);
    }
    
    function edit_profile_view(){
        $data['title'] = "Edit Profile";
        $data['mid_content'] = 'content/utilities/edit_profile';
        $this->load->model('employee');
        $data['employees'] = $this->employee->get_all_emp();
        $username = $this->session->userdata('username');
        $data['result'] = $this->employee->get_detail_emp($username);
        $this->load->view('includes/home_template', $data);
    }

}