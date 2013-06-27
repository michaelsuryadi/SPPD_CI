<?php

class Emp extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    function index() {
        $data['title'] = 'List Employees Data';
        $data['mid_content'] = 'content/employee/list_employee';
        $this->load->model('employee');
        $data['employees'] = $this->employee->get_all_emp();

        $username = $this->session->userdata('username');
        $data['result'] = $this->employee->get_detail_emp($username);
        $this->load->view('includes/home_template', $data);
    }

    function add_emp() {
        $res = $this->get_session();
        $data['result'] = $res['result'];

        $this->load->model('job');
        $data['jobs'] = $this->job->get_all_job();
        $data['job_curr'] = $this->job->load_curr_num();
        $this->load->model('employee');
        $data['emp_curr_num'] = $this->employee->load_curr_num();
        
        $this->load->model('organization');
        $data['org'] = $this->organization->get_all_org();
        
        $data['title'] = 'Add New Employee';
        $data['mid_content'] = 'content/employee/add_employee';
        $this->load->view('includes/home_template', $data);
    }

    function get_session() {
        $this->load->model('employee');
        $username = $this->session->userdata('username');
        $data['result'] = $this->employee->get_detail_emp($username);

        return $data;
    }

    function process_add() {
        $this->load->model('employee');
        $q = $this->employee->add_employee();

        if ($q) {
            redirect('emp');
        } else {
            redirect('emp/add_emp');
        }
    }

    function view() {
        $get = $this->uri->uri_to_assoc();
        $this->load->model('employee');
        $data['res'] = $get['id'];
        $this->load->model('job');
        $data['jobs'] = $this->job->get_all_job();

        $this->load->model('organization');
        $data['org'] = $this->organization->get_all_org();
        $data['employee_data'] = $this->employee->get_emp_data($data['res']);
        
        $data['title'] = 'Employee Profile';
        $data['mid_content'] = 'content/employee/update_employee';
        $res = $this->get_session();

        $data['user_data'] = $this->employee->get_user_data($data['res']);
        $orgid = $data['employee_data']->row()->org_id;

        $data['job'] = $this->job->load_job_by_org($orgid);
        
        $data['result'] = $res['result'];
        $this->load->view('includes/home_template', $data);
    }

    function process_update() {
        $this->load->model('employee');
        $q = $this->employee->update_emp();

        if ($q) {
            redirect('/emp');
        } else {
            redirect('/emp');
        }
    }

    function filter_emp() {
        $data['title'] = 'List Employees Data';
        $data['mid_content'] = 'content/employee/list_employee';
        $this->load->model('employee');
        $data['employees'] = $this->employee->get_filter_employee();
        $username = $this->session->userdata('username');
        $data['result'] = $this->employee->get_detail_emp($username);
        $this->load->view('includes/home_template', $data);
    }
    
    function load_emp_per_org(){
        $this->load->model('employee');
        $q = $this->employee->load_emp_by_org();
        echo $q;
    }

}