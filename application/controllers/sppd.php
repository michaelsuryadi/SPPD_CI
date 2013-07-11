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
        $data['fiatur'] = $this->employee->get_fiatur_by_org($emp_data->org_id);
        $data['app_config'] = $this->admin_config->load_app_config();
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
        $data['sppd_list'] = $dt['sppd_list']['proses_sppd'];
        $data['sppd_tolak'] = $dt['sppd_list']['reject_sppd'];
        $data['app_config'] = $this->admin_config->load_app_config();
        $this->load->view('includes/home_template', $data);
    }

    function perlu_proses_sppd() {
        $data['title'] = 'SPPD Perlu Diproses';
        $data['mid_content'] = 'content/sppd/perlu_proses_sppd';
        $this->load->model('employee');
        $this->load->model('sppds');
        $username = $this->session->userdata('username');
        $data['result'] = $this->employee->get_detail_emp($username);
        $row = $data['result']->row();
        $empId = $row->emp_num;
        $data['sppd_list'] = $this->sppds->list_perlu_diproses($empId);
        $data['draft2'] = $this->sppds->get_proses_sppd($empId);
        $data['draft'] = $data['draft2']['proses_sppd'];
        $data['app_config'] = $this->admin_config->load_app_config();
        $this->load->view('includes/home_template', $data);
    }

    function draft_sppd() {
        $data['title'] = 'SPPD Draft';
        $data['mid_content'] = 'content/sppd/draft_sppd';
        $this->load->model('employee');
        $username = $this->session->userdata('username');
        $data['result'] = $this->employee->get_detail_emp($username);
        $this->load->library('pagination');
        $row = $data['result']->row();
        $empId = $row->emp_num;
        $this->load->model('sppds');

        $config['base_url'] = 'http://127.0.0.1/sppd_ci/index.php/sppd/draft_sppd';
        $config['per_page'] = 4;
        $config['num_links'] = 10;
        $config['uri_segment'] = 3;
        $config['total_rows'] = $this->sppds->get_draft_sppd($empId,$config['num_links'],$this->uri->segment(3));
        $this->pagination->initialize($config);
        
        $data['draft'] = $this->sppds->get_draft_sppd($empId,$config['per_page'],$config['uri_segment']);
        
        
        $data['app_config'] = $this->admin_config->load_app_config();
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

    function edit() {
        $get = $this->uri->uri_to_assoc();
        $sppdId = $get['id'];
        $this->load->model('sppds');

        $data['data_sppd'] = $this->sppds->load_data_sppd($sppdId);
        $data['data_komentar'] = $this->sppds->load_comment($sppdId);
        $data['pemeriksa'] = $this->sppds->load_pemeriksa_sppd($sppdId);

        $data['title'] = 'View SPPD';
        $data['mid_content'] = 'content/sppd/edit_sppd';

        $this->load->model('employee');
        $username = $this->session->userdata('username');
        $data['result'] = $this->employee->get_detail_emp($username);
        $data['app_config'] = $this->admin_config->load_app_config();
        $this->load->view('includes/home_template', $data);
    }

    function show_exam() {
        $data['title'] = 'Pilih Pemeriksa';
        $this->load->model('employee');
        $username = $this->session->userdata('username');


        if ($this->input->post('keyword') == null || $this->input->post('keyword') == "") {
            $query = $this->employee->get_detail_emp($username);
            $res = $query->row();
            $mgrId = 0;
            $arrdata = array();
            $data['all_atasan'] = $this->employee->get_all_atasan($mgrId, $arrdata, 0);
        } else {
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
        $data['pemeriksa'] = $this->sppds->load_pemeriksa_sppd($sppdId);

        $data['order'] = $this->sppds->get_order_pemeriksa($sppdId);
        $data['title'] = 'View SPPD';
        $data['mid_content'] = 'content/sppd/view_sppd';

        $this->load->model('employee');
        $username = $this->session->userdata('username');
        $data['result'] = $this->employee->get_detail_emp($username);
        $data['anggaran'] = $this->sppds->get_sisa_anggaran();
        $data['rincian_angkutan'] = $this->sppds->load_perincian_angkutan($sppdId);
        $data['rincian_harian'] = $this->sppds->load_perincian_harian($sppdId);
        
        $data['app_config'] = $this->admin_config->load_app_config();
        $this->load->view('includes/home_template', $data);
    }

    function approve_sppd() {
        $this->load->model('sppds');
        $q = $this->sppds->upd_sppd();

        if ($q) {
            redirect("/sppd/perlu_proses_sppd");
        }
    }

    function view_sedang_proses_sppd() {


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
        $data['app_config'] = $this->admin_config->load_app_config();
        $this->load->view("includes/home_template", $data);
    }

    function view_telah_proses_sppd() {
        $get = $this->uri->uri_to_assoc();
        $sppdId = $get['id'];
        $this->load->model('sppds');
        $this->load->model('reservation_model');

        $data['data_sppd'] = $this->sppds->load_data_sppd($sppdId);
        $data['data_komentar'] = $this->sppds->load_comment($sppdId);
        $data['title'] = 'View SPPD Sedang Diproses';
        $data['mid_content'] = 'content/sppd/telah_proses_sppd_view';
        $this->load->model('employee');
        $username = $this->session->userdata('username');
        $data['result'] = $this->employee->get_detail_emp($username);
        $data['rservation_detail'] = $this->reservation_model->load_request_data($sppdId);
        $data['app_config'] = $this->admin_config->load_app_config();
        $employee = $data['result'];
        $data['rincian_angkutan'] = $this->sppds->load_perincian_angkutan($sppdId);
        $data['rincian_harian'] = $this->sppds->load_perincian_harian($sppdId);

        $data['approval_prg'] = $this->sppds->get_approval($sppdId);

        $this->load->view("includes/home_template", $data);
    }

    function send_comment() {
        $this->load->model('sppds');
        $this->load->helper('date');

        date_default_timezone_set("Asia/Jakarta");
        $today = date("Y-m-d H:i:s");
        $q = $this->sppds->send_comment_data();

        if ($q) {
            echo $today . " - " . $q->emp_firstname . " " . $q->emp_lastname . " - <i>" . $this->input->post('isi') . "</i>";
        }
    }

    function show_emp() {
        $data['title'] = 'Pilih Pemeriksa';
        $this->load->model('employee');
        $username = $this->session->userdata('username');

        if ($this->input->post('keyword') == null || $this->input->post('keyword') == "") {
            $query = $this->employee->get_detail_emp($username);
            $res = $query->row();
            $mgrId = 0;
            $arrdata = array();
            $data['all_atasan'] = $this->employee->get_all_atasan($mgrId, $arrdata, 0);
        } else {
            $data['all_atasan'] = $this->employee->get_emp_byname($this->input->post('keyword'));
        }

        $this->load->view('content/sppd/pilih_pemeriksa', $data);
    }

    function telah_proses_sppd() {
        $data['title'] = 'SPPD Perlu Diproses';
        $data['mid_content'] = 'content/sppd/telah_proses_sppd';
        $this->load->model('employee');
        $this->load->model('sppds');
        $username = $this->session->userdata('username');
        $data['result'] = $this->employee->get_detail_emp($username);
        $row = $data['result']->row();
        $empId = $row->emp_num;
        $data['sppd_list'] = $this->sppds->list_telah_diproses($empId);
        $data['app_config'] = $this->admin_config->load_app_config();
        $this->load->view('includes/home_template', $data);
    }

    function reject_sppd() {
        $this->load->model('sppds');
        $q = $this->sppds->reject_sppd();

        if ($q) {
            redirect('/sppd/perlu_proses_sppd');
        }
    }

    function edit_sppd_by_pemeriksa() {
        $get = $this->uri->uri_to_assoc();
        $sppdId = $get['id'];
        $this->load->model('sppds');

        $data['data_sppd'] = $this->sppds->load_data_sppd($sppdId);
        $data['data_komentar'] = $this->sppds->load_comment($sppdId);
        $data['pemeriksa'] = $this->sppds->load_pemeriksa_sppd($sppdId);

        $data['title'] = 'View SPPD';
        $data['mid_content'] = 'content/sppd/edit_sppd_by_pemeriksa';

        $this->load->model('employee');
        $username = $this->session->userdata('username');
        $data['result'] = $this->employee->get_detail_emp($username);
        $data['app_config'] = $this->admin_config->load_app_config();
        $this->load->view('includes/home_template', $data);
    }

    function process_edit() {
        $this->load->model('sppds');
        $q = $this->sppds->process_edit();

        if ($q) {
            redirect('/sppd/draft_sppd');
        }
    }

    function tolak_sppd() {
        $this->load->model('sppds');
        $q = $this->sppds->tolak_sppd();

        if ($q) {
            redirect('/sppd/perlu_proses_sppd');
        }
    }

    function process_update() {
        $sppdnum = $this->input->post('sppd_num2');
        echo $sppdnum;
        $this->load->model('sppds');
        $q = $this->sppds->update_sppd_by_pemeriksa();

        if ($q) {
            redirect('/sppd/view_sppd/id/' . $sppdnum);
        }
    }
    
    function view_form_perincian_biaya(){
        
        $this->load->view('content/sppd/form_perincian_biaya');
    }
    
    function simpan_perincian(){
        $this->load->model('sppds');
        $sppdnum = $this->input->post('sppdnum');
        $q = $this->sppds->simpan_perincian();
        
        if($q){
            redirect('/sppd/view_sppd/id/'.$sppdnum);
        }
    }

}
