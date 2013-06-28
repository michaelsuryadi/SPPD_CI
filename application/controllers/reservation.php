<?php

class Reservation extends CI_Controller{
    
    public function __construct() {
        parent::__construct();
    }
    
    function index(){
        phpinfo();
    }
    
    function flight_index(){
        if ($this->session->userdata('username') != "") {
            $data['title'] = 'Flight Reservation';
            $this->load->model('employee');
            $this->load->model('reservation_model');
            $username = $this->session->userdata('username');
            $data['result'] = $this->employee->get_detail_emp($username);
            $data['airport'] = $this->reservation_model->get_list_airport();
            echo ($data['airport']);
            $data['mid_content'] = 'content/reservation/flight/pre_reservation';
            $this->load->view('includes/home_template', $data);
        }
        else {
            redirect("/login");
        }
    }
    
    function process_req(){
        $this->load->model('reservation_model');
        $q = $this->reservation_model->process_req();
        if($q){
            echo 'OK';
        }
    }
    
    function view_all_reservation(){
        if ($this->session->userdata('username') != "") {
            $data['title'] = 'All Reservation';
            $this->load->model('employee');
            $this->load->model('reservation_model');
            $username = $this->session->userdata('username');
            $data['result'] = $this->employee->get_detail_emp($username);
            $data['reservation'] = $this->reservation_model->get_all_reservation_req();
            $data['mid_content'] = 'content/reservation/view_all_reservation';
            $this->load->view('includes/home_template', $data);
        }
        else {
            redirect("/login");
        }
    }
    
    function load_request(){
        $this->load->model('reservation_model');
        $q = $this->reservation_model->load_request();
        
        echo $q;
    }
}
