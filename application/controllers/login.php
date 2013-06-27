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

    /*
     * function untuk memvalidasi credential login
     */

    function validate_credentials() {
        $this->load->model('login_model');
        $query = $this->login_model->validate();

        if ($query) {
            $data = array(
                'username' => $this->input->post('username'),
                'is_logged_in' => TRUE
            );

            if (!$this->input->post('remember')) {
                $this->session->sess_expiration = 7200;
                $this->session->sess_expire_on_close = TRUE;
            }

            $this->session->set_userdata($data);

            if ($this->input->post('username') == "admin") {
                redirect('site/admin_index');
            } else {
                if ($this->input->post('username') == "reservation") {
                    redirect('site/home_reservation');
                } else {
                    redirect('site/index');
                }
            }
        } else {
            redirect('login/index');
        }
    }

    function signout() {
        $this->session->sess_destroy();
        $this->index();
    }

}