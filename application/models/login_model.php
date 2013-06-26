<?php

class Login_model extends CI_Model {

    function index(){
        
    }
    
    /*
     * Untuk mem-validasi login user
     */
    function validate() {
        $this->db->where('emp_username', $this->input->post('username'));
        $this->db->where('emp_password', md5($this->input->post('password')));
        $query = $this->db->get('hrms_user');

        if ($query->num_rows() == 1) {
            return true;
        }
        else {
            return false;
        }
    }

}
