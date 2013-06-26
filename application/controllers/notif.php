<?php

class Notif extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
    }
    
    function index(){
        if ($this->session->userdata('username') != "") {
            $data['title'] = 'Notification';
            $this->load->model('employee');
            
            $username = $this->session->userdata('username');
            $data['result'] = $this->employee->get_detail_emp($username);

            $dt = $data['result']->row();

            $this->load->model('notifications');
            $data['notif'] = $this->notifications->get_notifications($dt->emp_num);
            $data['mid_content'] = 'content/notifications/notif_view';
            $this->load->view('includes/home_template', $data);
        }
        else {
            redirect("/login");
        }
    }
    
    /*
     * Function untuk menghapus notification
     */
    function delete_notif(){
        $get = $this->uri->uri_to_assoc();
        $id = $get['id'];
        
        $this->load->model('notifications');
        $q = $this->notifications->delete($id);
        
        if($q){
            redirect('/notif');
        }
    }
}
