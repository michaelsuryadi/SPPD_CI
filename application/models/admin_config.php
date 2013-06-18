<?php

class Admin_config extends CI_Model {
    
    function upd_config_data(){
        $data = array(
            "emp_start_num"=> $this->input->post('emp_start'),
            "emp_counter_id"=>"1",
            "sppd_start_num"=> $this->input->post('sppd_start'),
            "sppd_counter_id"=>"1",
            "job_start_num" => $this->input->post('job_start'),
            "job_counter_id" => "1"
        );
        
        $q = $this->db->insert("hrms_counter",$data);
        if($q){
            return true;
        }
        else {
            return false;
        }
    }
    
    function load_config_data(){
        return $this->db->get("hrms_counter");
    }
    
}
