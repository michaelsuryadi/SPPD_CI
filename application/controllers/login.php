<?php

class Login extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    function index() {
        if ($this->session->userdata('username') != null) {
            redirect('/site');
        } else {
            $data['title'] = 'Login';
            $data['mid_content'] = 'content/login/login';
            $this->load->view('includes/login_template', $data);
        }
    }

    function validate_credentials() {
        $this->load->model('login_model');
        $query = $this->login_model->validate();

        if ($query) {
            $data = array(
                'username' => $this->input->post('username'),
                'is_logged_in' => TRUE
            );

            $this->session->set_userdata($data);
            redirect('site/index');
        } else {
            redirect('login/index');
        }
    }

    function signout() {
        $this->session->sess_destroy();
        $this->index();
    }

}