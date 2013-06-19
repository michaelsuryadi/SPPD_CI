<?php

class Admin_config extends CI_Model {

    function upd_config_data() {
        $data = array(
            "emp_start_num" => $this->input->post('emp_start'),
            "emp_counter_id" => "1",
            "sppd_start_num" => $this->input->post('sppd_start'),
            "sppd_counter_id" => "1",
            "job_start_num" => $this->input->post('job_start'),
            "job_counter_id" => "1"
        );

        $q = $this->db->insert("hrms_counter", $data);
        if ($q) {
            return true;
        } else {
            return false;
        }
    }

    function load_config_data() {
        return $this->db->get("hrms_counter");
    }

    function save_sppd_flow() {
        $this->db->empty_table('flow_sppd');

        $fitur = $this->input->post('fitur_id');
        $empnum = $this->input->post('emp_num');


        for ($i = 0; $i < count($fitur); $i++) {
            $data = array(
                "fitur_id" => $fitur[$i],
                "emp_num" => $empnum[$i]
            );
            $this->db->insert("flow_sppd", $data);
        }
        return true;
    }

    function get_list_flow_sppd() {
        $this->db->select('B.emp_num,A.fitur_id,B.emp_id,B.emp_firstname,B.emp_lastname,C.job_name,D.org_name');
        $this->db->from('flow_sppd as A');
        $this->db->join('hrms_employees as B', 'A.emp_num=B.emp_num');
        $this->db->join('hrms_job as C', 'B.emp_job=C.job_num');
        $this->db->join('hrms_organization as D', 'B.org_id=D.org_num');
        $this->db->where('A.fitur_id', '3');
        $this->db->or_where('A.fitur_id', '4');
        $this->db->order_by('A.flow_id', "ASC");
        $q = $this->db->get();
        return $q;
    }
    
    function hapus_pemeriksa($id) {
        $this->db->where("emp_num",$id);
        $q = $this->db->delete("flow_sppd");
        
        if($q){
            return true;
        }
        else {
            return false;
        }
    }

}
