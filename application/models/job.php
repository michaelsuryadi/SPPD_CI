<?php

class Job extends CI_Model {
    
    function get_all_job(){
        $this->db->select('A.job_num,A.job_id,A.job_name,A.job_description,B.org_name');
        $this->db->from('hrms_job as A');
        $this->db->join('hrms_organization as B','B.org_num=A.org_num');
        $this->db->order_by("A.job_id","ASC");
        $query = $this->db->get();
        
        return $query;
    }
    
    function add_job(){
        $data = array(
          'job_id'=>$this->input->post('job_id'),
          'job_name'=>$this->input->post('job_name'),
          'job_description' =>$this->input->post('job_description'),
          'org_num'=> $this->input->post('organization'),
          'emp_num'=> $this->input->post('manager')
        );
        
        $q = $this->db->insert('hrms_job',$data);
        
        if($q){
            return true;
        }
        else {
            return false;
        }
    }
    
    function get_job_data($id){
        $this->db->select('*');
        $this->db->from('hrms_job');
        $this->db->where('job_num',$id);
        $q = $this->db->get();
        
        return $q;
    }
    
    function upd_job(){
        $data = array(
          'job_id'=>$this->input->post('job_id'),
          'job_name'=>$this->input->post('job_name'),
          'job_description' =>$this->input->post('job_description'),
          'org_num' => $this->input->post('org')
        );
        
        $this->db->where('job_id',$this->input->post('job_id'));
        $q = $this->db->update('hrms_job',$data);
    
        if($q){
            return true;
        }
        else {
            return false;
        }
    }
    
    function get_job_data_by_code($jobcode){
        $this->db->select('A.job_name, B.org_name');
        $this->db->from('hrms_job as A');
        $this->db->join('hrms_organization as B','A.org_num=B.org_num');
        $this->db->where('A.job_code',$jobcode);
        
        $q = $this->db->get();
        
        return $q;
    } 
    
    function get_filter_job(){
        
        $this->db->select('A.emp_id,A.emp_firstname,A.emp_lastname,A.emp_dob,A.emp_email,A.emp_work_telp,A.emp_street,B.job_name');
        $this->db->from('hrms_job as A');
        $this->db->join('hrms_job as B','A.emp_job = B.job_num');
        $this->db->where('A.emp_firstname not like','admin');
        
        if($this->input->post('keyword')!=""){
            $this->db->like(mb_strtolower($this->input->post('filter')),mb_strtolower($this->input->post('keyword')));
        }
        $query = $this->db->get();
        
        return $query;
    }
    
    function get_job_code($jobnum){
        $this->db->select('job_code');
        $this->db->from('hrms_job');
        $this->db->where('job_num',$jobnum);
        $q = $this->db->get();
        
        $row = $q->row();
        
        return $row->job_code;
    }
    
    function list_job_by_org(){
        $orgnum = $this->input->post('org');
        
        $this->db->select('A.job_num,A.job_code,A.job_name,A.emp_num,A.job_id,B.org_code');
        $this->db->from('hrms_job as A');
        $this->db->where('A.org_num',$orgnum);
        $this->db->join('hrms_organization as B','A.org_num=B.org_num');
        $q = $this->db->get();
        
        return json_encode($q->result_array());
    }
    
        function get_mgr_detail(){
        $jobnum = $this->input->post('job_num');
        
        $this->db->select("B.emp_id,B.emp_num,B.emp_firstname,B.emp_lastname,A.job_code,C.org_code");
        $this->db->from("hrms_job as A");
        $this->db->where("A.job_num",$jobnum);
        $this->db->join("hrms_employees as B","A.emp_num=B.emp_num");
        $this->db->join("hrms_organization as C", "A.org_num=C.org_num");
        $q = $this->db->get();
        return json_encode($q->result_array());
    }
    
    function load_curr_num(){
        $this->db->select('job_start_num,job_counter_id');
        $this->db->from('hrms_counter');
        $q = $this->db->get();
        
        $row = $q->row();
        $curr_num = $row->job_start_num + $row->job_counter_id;
        return $curr_num;
    }
}