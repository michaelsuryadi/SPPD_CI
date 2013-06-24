<?php

class Site extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    function index() {

        if ($this->session->userdata('username') != "") {
            $data['title'] = 'Home';
            $this->load->model('employee');
            $this->load->model('job');
            $username = $this->session->userdata('username');
            $data['result'] = $this->employee->get_detail_emp($username);

            $dt = $data['result']->row();
            $data['job'] = $this->job->get_job_data_by_code($dt->job_code)->row();

            $this->load->model('notifications');
            $data['notif'] = $this->notifications->get_notifications($dt->emp_num);
            $data['mid_content'] = 'content/home/home';
            $this->load->view('includes/home_template', $data);
        }
        else {
            redirect("/login");
        }
    }
    
    function admin_index(){
        $data['title'] = 'Home';
            $this->load->model('employee');
            $this->load->model('job');
            $username = $this->session->userdata('username');
            $data['result'] = $this->employee->get_detail_emp($username);

            $dt = $data['result']->row();
            $data['job'] = $this->job->get_job_data_by_code($dt->job_code)->row();

            $this->load->model('notifications');
            $data['notif'] = $this->notifications->get_notifications($dt->emp_num);
            $data['mid_content'] = 'content/home/home_admin';
            $this->load->view('includes/home_template', $data);
    }
    
    function notif_redirect(){
        $get = $this->uri->uri_to_assoc();
        $id = $get['id'];
        $this->load->model('notifications');
        $address = $this->notifications->get_url_address($id);
        
        redirect($address);
    }

}
