<?php

class Sppd extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    function index() {
        
    }

    function new_sppd() {
        $data['title'] = 'New SPPD';
        $data['mid_content'] = 'content/sppd/create_sppd';
        $this->load->model('employee');
        $username = $this->session->userdata('username');
        $data['result'] = $this->employee->get_detail_emp($username);

        $employee = $data['result'];
        $emp_data = $employee->row();
        
        $data['pemeriksa'] = $this->employee->load_pemeriksa_sppd();
        
//        $data['fiatur'] = $this->employee->load_fiatur($emp_data->org_id);
//        $data['perinci'] = $this->employee->load_rinci($emp_data->org_id);
//        $data['posting'] = $this->employee->load_posting($emp_data->org_id);

        $this->load->view('includes/home_template', $data);
    }

    function proses_sppd() {
        $data['title'] = 'SPPD Sedang Diproses';
        $data['mid_content'] = 'content/sppd/sedang_proses_sppd';
        $this->load->model('employee');
        $this->load->model('sppds');
        $username = $this->session->userdata('username');
        $data['result'] = $this->employee->get_detail_emp($username);
        $row = $data['result']->row();
        $empId = $row->emp_num;
        $dt['sppd_list'] = $this->sppds->get_proses_sppd($empId);
        $data['sppd_list'] = $dt['sppd_list'][0];
        $this->load->view('includes/home_template', $data);
    }
    
    function perlu_proses_sppd(){
        $data['title'] = 'SPPD Perlu Diproses';
        $data['mid_content'] = 'content/sppd/perlu_proses_sppd';
        $this->load->model('employee');
        $this->load->model('sppds');
        $username = $this->session->userdata('username');
        $data['result'] = $this->employee->get_detail_emp($username);
        $row = $data['result']->row();
        $empId = $row->emp_num;
        $data['sppd_list'] = $this->sppds->list_perlu_diproses($empId);
        $data['draft'] = $this->sppds->get_proses_sppd($empId);

        $this->load->view('includes/home_template', $data);
    }

    function draft_sppd() {
        $data['title'] = 'SPPD Draft';
        $data['mid_content'] = 'content/sppd/draft_sppd';
        $this->load->model('employee');
        $username = $this->session->userdata('username');
        $data['result'] = $this->employee->get_detail_emp($username);

        $row = $data['result']->row();
        $empId = $row->emp_num;

        $this->load->model('sppds');
        $data['draft'] = $this->sppds->get_draft_sppd($empId);

        $this->load->view('includes/home_template', $data);
    }

    function hapus() {
        $get = $this->uri->uri_to_assoc();
        $sppdId = $get['id'];

        $this->load->model('sppds');
        $q = $this->sppds->remove($sppdId);

        if ($q) {
            redirect('/sppd/draft_sppd');
        }
    }
    
    function edit(){
        $get = $this->uri->uri_to_assoc();
        $sppdId = $get['id'];
        $this->load->model('sppds');
        
        $data['data_sppd'] = $this->sppds->load_data_sppd($sppdId);
        $data['data_komentar'] = $this->sppds->load_comment($sppdId);
        $data['title'] = 'View SPPD';
        $data['mid_content'] = 'content/sppd/edit_sppd';
        
        $this->load->model('employee');
        $username = $this->session->userdata('username');
        $data['result'] = $this->employee->get_detail_emp($username);
        
        $this->load->view('includes/home_template', $data);
        
    }

    function show_exam() {
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
        
        $this->load->view('content/sppd/pilih_pemeriksa_sppd', $data);
    }

    function process() {
        $this->load->model('sppds');
        $q = $this->sppds->add_new_sppd();

        if ($q) {
            redirect('/sppd/proses_sppd');
        } else {
            redirect('/sppd/new_sppd');
        }
    }
    
    function view_sppd() {
        $get = $this->uri->uri_to_assoc();
        $sppdId = $get['id'];
        $this->load->model('sppds');
        
        $data['data_sppd'] = $this->sppds->load_data_sppd($sppdId);
        $data['data_komentar'] = $this->sppds->load_comment($sppdId);
        $data['title'] = 'View SPPD';
        $data['mid_content'] = 'content/sppd/view_sppd';
        
        $this->load->model('employee');
        $username = $this->session->userdata('username');
        $data['result'] = $this->employee->get_detail_emp($username);
        
        $this->load->view('includes/home_template', $data);
    }
    
    function approve_sppd(){
        $this->load->model('sppds');
        $q = $this->sppds->upd_sppd();
        
        if($q){
            redirect("/sppd/perlu_proses_sppd");
        }
    }
    
    function view_sedang_proses_sppd(){
        
        
        $get = $this->uri->uri_to_assoc();
        $sppdId = $get['id'];
        $this->load->model('sppds');
        
        $data['data_sppd'] = $this->sppds->load_data_sppd($sppdId);
        $data['data_komentar'] = $this->sppds->load_comment($sppdId);
        $data['title'] = 'View SPPD Sedang Diproses';
        $data['mid_content'] = 'content/sppd/sedang_proses_sppd_view';
        $this->load->model('employee');
        $username = $this->session->userdata('username');
        $data['result'] = $this->employee->get_detail_emp($username);
        $employee = $data['result'];
        
        
        $data['approval_prg'] = $this->sppds->get_approval($sppdId);
        
        $this->load->view("includes/home_template",$data);
    }
    
    function send_comment(){
        $this->load->model('sppds');
        $this->load->helper('date');
        $datestring = "%Y-%m-%d";
        $datestring2 = "%h:%i %a";
        $time = time();
        $tgl = mdate($datestring, $time);
        $wkt = mdate($datestring2,$time);
        $q = $this->sppds->send_comment_data();
        
        if($q) {
            echo $tgl." - ".$wkt." - ".$q->emp_firstname." ".$q->emp_lastname." - <i>".$this->input->post('isi')."</i>";
        }
    }
    
    function show_emp(){
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
        
        $this->load->view('content/sppd/pilih_pemeriksa', $data);
    }
    
    function telah_proses_sppd(){
        $data['title'] = 'SPPD Perlu Diproses';
        $data['mid_content'] = 'content/sppd/telah_proses_sppd';
        $this->load->model('employee');
        $this->load->model('sppds');
        $username = $this->session->userdata('username');
        $data['result'] = $this->employee->get_detail_emp($username);
        $row = $data['result']->row();
        $empId = $row->emp_num;
        $data['sppd_list'] = $this->sppds->list_telah_diproses($empId);

        $this->load->view('includes/home_template', $data);
    }
}
