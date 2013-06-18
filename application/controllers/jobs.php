<?php

class Jobs extends CI_Controller {

    function index() {
        $this->load->model('employee');
        $this->load->model('job');
        $username = $this->session->userdata('username');

        $data['job'] = $this->job->get_all_job();
        $data['result'] = $this->employee->get_detail_emp($username);
        $data['title'] = 'Jobs';
        $data['mid_content'] = 'content/job/list_job';
        $this->load->view('includes/home_template', $data);
    }

    function form_job() {
        $res = $this->get_session();
        $data['result'] = $res['result'];
        $data['title'] = 'Add Job';
        $this->load->model('organization');
        
        $this->load->model('job');
        $data['job_curr_num'] = $this->job->load_curr_num();
        
        $data['org'] = $this->organization->get_all_org();
        $data['mid_content'] = 'content/job/add_job';
        $this->load->view('includes/home_template', $data);
    }

    function get_session() {
        $this->load->model('employee');
        $username = $this->session->userdata('username');
        $data['result'] = $this->employee->get_detail_emp($username);

        return $data;
    }

    function process_add() {
        $this->load->model('job');
        $q = $this->job->add_job();

        if ($q) {
            redirect('/jobs');
        }
    }

    function upd() {
        $get = $this->uri->uri_to_assoc();
        $data['id'] = $get['id'];
        $this->load->model('job');
        $data['job_data'] = $this->job->get_job_data($data['id']);

        $res = $this->get_session();
        $data['result'] = $res['result'];
        $this->load->model('organization');
        $data['org'] = $this->organization->get_all_org();
        $data['title'] = 'Update Job';
        $data['mid_content'] = 'content/job/update_job';
        $this->load->view('includes/home_template', $data);
    }

    function process_update() {
        $this->load->model('job');
        $q = $this->job->upd_job();

        if ($q) {
            redirect('/jobs');
        }
    }
    
    function load_job(){
        $this->load->model('job');
        $q = $this->job->list_job_by_org();
        echo $q;
    }
    
    function load_mgr(){
        $this->load->model('job');
        $q = $this->job->get_mgr_detail();
        echo $q;
    }
    

}
