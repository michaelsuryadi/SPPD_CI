<?php

class Reservation extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    function index() {
        phpinfo();
    }

    function flight_index() {
        if ($this->session->userdata('username') != "") {
            $data['title'] = 'Flight Reservation';
            $this->load->model('employee');
            $this->load->model('reservation_model');
            $username = $this->session->userdata('username');
            $data['result'] = $this->employee->get_detail_emp($username);
            $data['airport'] = $this->reservation_model->get_list_airport();
            $data['app_config'] = $this->admin_config->load_app_config();
            $data['mid_content'] = 'content/reservation/flight/pre_reservation';
            $this->load->view('includes/home_template', $data);
        } else {
            redirect("/login");
        }
    }

    function process_req() {
        $this->load->model('reservation_model');
        $q = $this->reservation_model->process_req();
        if ($q) {
            echo 'OK';
        }
    }

    function view_all_reservation() {
        if ($this->session->userdata('username') != "") {
            $data['title'] = 'All Reservation';
            $this->load->model('employee');
            $this->load->model('reservation_model');
            $username = $this->session->userdata('username');
            $data['result'] = $this->employee->get_detail_emp($username);
            $data['app_config'] = $this->admin_config->load_app_config();
            $data['reservation'] = $this->reservation_model->get_all_reservation_req();
            $data['mid_content'] = 'content/reservation/view_all_reservation';
            $this->load->view('includes/home_template', $data);
        } else {
            redirect("/login");
        }
    }

    function load_request() {
        $this->load->model('reservation_model');
        $q = $this->reservation_model->load_request();

        echo $q;
    }

    function reservation_view() {
        $get = $this->uri->uri_to_assoc();
        $id = $get['id'];

        if ($this->session->userdata('username') != "") {
            $data['title'] = 'Detail Reservasi';
            $this->load->model('employee');
            $this->load->model('reservation_model');
            $username = $this->session->userdata('username');
            $data['result'] = $this->employee->get_detail_emp($username);

//            $this->load->model('reservation_model');
//            $data['airport'] = (array) $this->reservation_model->get_list_airport();
            $data['reservation'] = $this->reservation_model->get_detail_reservation($id);
            $data['booking'] = $this->reservation_model->get_list_booking($id);
//            $data['country'] = (array)$this->reservation_model->get_list_country();
            $data['mid_content'] = 'content/reservation/reservation_view';
            $data['app_config'] = $this->admin_config->load_app_config();
            $this->load->view('includes/home_template', $data);
        } else {
            redirect("/login");
        }
    }
    
    function get_available_airline(){
        $this->load->model('reservation_model');
        $q = $this->reservation_model->get_available_airline();
        
        echo $q;
    }
    
    function get_country(){
        $this->load->model('reservation_model');
        $data['country'] = $this->reservation_model->get_list_country();
        
        print_r($data['country']);
    }
    
    function search_flight(){
        $this->load->model('reservation_model');
        $q = $this->reservation_model->search_flight();
        
        echo $q;
    }
    
    function get_list_city() {
        $this->load->model('reservation_model');
        $q = $this->reservation_model->get_list_city();
        echo $q->Cities;
    }
    
    function get_build_pnr(){
        $this->load->model('reservation_model');
        $q = $this->reservation_model->get_build_pnr();
        
        echo $q;
    }
    
    function process_booking(){
        $this->load->model('reservation_model');
        $q = $this->reservation_model->process_booking();
        
        echo $q;
    }

}
