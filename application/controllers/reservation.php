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
}
