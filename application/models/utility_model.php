<?php

class Utility_model extends CI_Model {
    
    function process_change_password() {
        $this->db->select('emp_password');
        $this->db->from('hrms_user');
        $this->db->where('emp_username',$this->session->userdata('username'));
        
        $query = $this->db->get();
        $row = $query->row();
        
        $pass = $row->emp_password;
        
        if(md5($this->input->post('old'))==$pass){
            $newPass = md5($this->input->post('new'));
            $confirmPass = md5($this->input->post('confirm'));
            
            if($newPass==$confirmPass){
                $data = array(
                    "emp_password"=>$newPass
                );
                
                $this->db->where('emp_username',$this->session->userdata('username'));
                $q = $this->db->update('hrms_user',$data);
                
                if($q){
                    return true;
                }
                else {
                    return false;
                }
            }
            else{
                return false;
            }
            
        }
        
    }
}
