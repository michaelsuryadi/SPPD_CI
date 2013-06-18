<?php

class Sppd_config extends CI_Controller {
    public function __construct() {
        parent::__construct();
    }
    
    function index(){
        $data['title'] = 'SPPD Configuration';
        $data['mid_content'] = 'content/config/sppd_config';
        $this->load->model('employee');
        $data['employees'] = $this->employee->get_all_emp();
        
        $username = $this->session->userdata('username');
        $data['result'] = $this->employee->get_detail_emp($username);
        $this->load->view('includes/home_template', $data);
    }
    
    function show_exam() {
        $get = $this->uri->uri_to_assoc();
        $id = $get['id'];
        $data['id'] = $id;
        $data['title'] = 'Pilih Pemeriksa';
        $this->load->model('employee');
        $username = $this->session->userdata('username');
        
        if ($this->input->post('keyword') == null || $this->input->post('keyword') == "") {
            $query = $this->employee->get_detail_emp($username);
            $res = $query->row();
            $mgrId = $this->employee->get_mgr_id($res->emp_num);
            $arrdata = array();
            $data['all_atasan'] = $this->employee->get_all_atasan($mgrId, $arrdata, 0);
        }
        else {
            $data['all_atasan'] = $this->employee->get_emp_byname($this->input->post('keyword'));
        }
        
        $this->load->view('content/config/show_all_pemeriksa', $data);
    }
}
