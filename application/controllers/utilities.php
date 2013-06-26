<?php

class Utilities extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    /*
     * Menampilkan form untuk mengganti password
     */
    function change_password_view() {
        $data['title'] = "Change Password";
        $data['mid_content'] = 'content/utilities/change_password';
        $this->load->model('employee');
        $data['employees'] = $this->employee->get_all_emp();
        $username = $this->session->userdata('username');
        $data['result'] = $this->employee->get_detail_emp($username);
        $this->load->view('includes/home_template', $data);
    }

    /*
     * Function untuk memproses pergantian password user
     */
    function process_change_password() {
        $this->load->model('utility_model');
        $query = $this->utility_model->process_change_password();

        if ($query) {
            if ($this->session->userdata('username') == 'admin') {
                redirect('/site/admin_index');
            } else {
                redirect('/site');
            }
        } else {
            redirect('/utilities/change_password_view');
        }
    }

    /*
     * Function untuk menampilkan halaman help
     */
    function help_view() {
        $data['title'] = "Help";
        $data['mid_content'] = 'content/utilities/help';
        $this->load->model('employee');
        $data['employees'] = $this->employee->get_all_emp();
        $username = $this->session->userdata('username');
        $data['result'] = $this->employee->get_detail_emp($username);
        $this->load->view('includes/home_template', $data);
    }

    /*
     * Function untuk menampilkan form untuk edit profile
     */
    function edit_profile_view() {
        $data['title'] = "Edit Profile";
        $data['mid_content'] = 'content/utilities/edit_profile';
        $this->load->model('employee');
        $data['employees'] = $this->employee->get_all_emp();
        $data['employee_data'] = $this->employee->get_employee_data_by_username();
        $username = $this->session->userdata('username');
        $data['result'] = $this->employee->get_detail_emp($username);
        $this->load->view('includes/home_template', $data);
    }
    
    /*
     * Function untuk mem-process edit profile
     */
    function process_edit_profile(){
        $this->load->model('utility_model');
        $q = $this->utility_model->process_edit_profile();
        
        if($q){
            redirect('/site');
        }
        else {
            redirect('/utilities/edit_profile_view');
        }
    }
}