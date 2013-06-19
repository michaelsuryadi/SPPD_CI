<?php

class Employee extends CI_Model {
    function get_detail_emp($username){
        $this->db->select('A.emp_num,A.emp_id as id_emp,A.emp_firstname,A.emp_lastname,A.job_code,A.org_code,A.org_id,B.emp_role');
        $this->db->from ('hrms_employees as A');
        $this->db->join('hrms_user as B','A.emp_num = B.emp_id');
        $this->db->where('B.emp_username',$username);
        $query = $this->db->get();
        return $query;
    }
    
    function get_all_emp(){
        $this->db->select('A.emp_id,A.emp_num,A.emp_firstname,A.emp_lastname,A.emp_dob,A.emp_email,A.emp_work_telp,A.emp_street,B.job_name');
        $this->db->from('hrms_employees as A');
        $this->db->join('hrms_job as B','A.emp_job = B.job_num');
        $this->db->where('A.emp_firstname not like','admin');
        $this->db->order_by('A.emp_num','ASC');
        $q = $this->db->get();
        
        return $q;
    }
    
    function add_employee(){
        $data = array(
            "emp_id"=>  $this->input->post('emp_id'),
            "emp_firstname"=> $this->input->post('emp_firstname'),
            "emp_lastname"=> $this->input->post('emp_lastname'),
            "emp_gender"=> $this->input->post('gender'),
            "emp_dob"=> $this->input->post("emp_dob"),
            "emp_street"=> $this->input->post("emp_street"),
            "emp_work_telp"=> $this->input->post("emp_work_telp"),
            "emp_email" => $this->input->post("emp_email"),
            "emp_reg_salary"=>$this->input->post("reg_salary"),
            "emp_over_salary"=>$this->input->post("over_salary"),
            "mgr_id" => $this->input->post("mgr_num"),
            "emp_cutah" =>"10",
            "emp_trip" =>"10",
            "emp_cubes" =>"10",
            "emp_job" =>$this->input->post("emp_job"),
            "job_code"=>$this->input->post('job_code'),
            "org_code"=>$this->input->post('org_code'),
            "org_id" => $this->input->post("emp_org")
        );
        
        
        $q = $this->db->insert('hrms_employees',$data);
        $this->db->select('emp_num');
        $this->db->from('hrms_employees');
        $this->db->where('emp_id',$this->input->post('emp_id'));
        $q3 = $this->db->get();
        $data3 = $q3->row();
        $empnum = $data3->emp_num;
        
        $data2 = array(
            "emp_id"=> $empnum,
            "emp_username"=>$this->input->post('username'),
            "emp_password"=>md5($this->input->post('password'))
        );
        
        $q2 = $this->db->insert('hrms_user',$data2);
        if($q && $q2){
            return true;
        }
        else {
            return false;
        }
    }
    
    function get_emp_data($user) {
        $this->db->select("*");
        $this->db->from('hrms_employees');
        $this->db->where('emp_num',$user);
        $query = $this->db->get();
        return $query;  
    }
    
    function get_user_data($user){
        $this->db->select('emp_id,emp_username,emp_password');
        $this->db->from('hrms_user');
        $this->db->where('emp_id',$user);
        $query = $this->db->get();
        
        return $query;
    }
    
    function update_emp(){
        
        $this->load->model('job');
        $job_code = $this->job->get_job_code($this->input->post('emp_job'));
        
        $this->load->model('organization');
        $org_code = $this->organization->get_org_code($this->input->post('emp_org'));
        
        $data = array(
            "emp_id"=>  $this->input->post('emp_id'),
            "emp_firstname"=> $this->input->post('emp_firstname'),
            "emp_lastname"=> $this->input->post('emp_lastname'),
            "emp_gender"=> $this->input->post('gender'),
            "emp_dob"=> $this->input->post("emp_dob"),
            "emp_street"=> $this->input->post("emp_street"),
            "emp_cutah" =>"10",
            "emp_trip" =>"10",
            "emp_cubes" =>"10",
            "emp_work_telp"=> $this->input->post("emp_work_telp"),
            "emp_email" => $this->input->post("emp_email"),
            "emp_job" => $this->input->post("emp_job"),
            "job_code"=>$job_code,
            "org_code"=>$org_code,
            "org_id" => $this->input->post("emp_org")
        );
        
        $data2 = array(
            "emp_id"=> $this->input->post('emp_num'),
            "emp_username"=>$this->input->post('username'),
            "emp_password"=>md5($this->input->post('password'))
        );
        
        $this->db->where('emp_id',$this->input->post('emp_id'));
        $this->db->update('hrms_employees',$data);
        
        if($this->input->post('password')!=""){
            $this->db->where('emp_id',$this->input->post('emp_num'));
            $this->db->update('hrms_user',$data2);
        }
    }
    function get_filter_employee(){
        
        $this->db->select('A.emp_id,A.emp_firstname,A.emp_lastname,A.emp_dob,A.emp_email,A.emp_work_telp,A.emp_street,B.job_name');
        $this->db->from('hrms_employees as A');
        $this->db->join('hrms_job as B','A.emp_job = B.job_num');
        $this->db->where('A.emp_firstname not like','admin');
        
        if($this->input->post('keyword')!=""){
            $this->db->like(mb_strtolower($this->input->post('filter')),mb_strtolower($this->input->post('keyword')));
        }
        
        $query = $this->db->get();
        
        return $query;
    }
    
    
    function get_all_atasan(){
        $this->db->select("A.emp_num,A.emp_id,A.emp_firstname,A.emp_lastname,A.mgr_id,C.job_code,A.org_code,C.job_name,D.org_name");
        $this->db->from('hrms_employees as A');
        $this->db->join('hrms_job as C','A.emp_job=C.job_num');
        $this->db->join('hrms_organization as D','A.org_id=D.org_num');
        $this->db->where('A.emp_num !=','24');
        $q = $this->db->get();
        
        
//        $d = $q->row();
//        if($d->mgr_id !=null){
//            $i++;
//            array_push($data, $d);
//            $this->get_all_atasan($d->mgr_id, $data,$i);
//        }
//        else {
//            array_push($data, $d);
//        }
        return $q;
        
        
    }
    
    function get_emp_byname($keyword){
        $this->db->select("A.emp_num,A.emp_id,A.emp_firstname,A.emp_lastname,A.mgr_id,C.job_code,A.org_code,C.job_name");
        $this->db->from('hrms_employees as A');
        $this->db->like(mb_strtolower('A.emp_firstname'),mb_strtolower($keyword));
        $this->db->join('hrms_job as C','A.emp_job=C.job_num');
        $q = $this->db->get();
        
        $data = array();
        foreach($q->result() as $row){
            array_push($data, $row);
        }
        
        return $data;
    }
    
    function get_mgr_id($empnum){
        $this->db->select('mgr_id');
        $this->db->from('hrms_employees');
        $this->db->where('emp_num',$empnum);
        $q = $this->db->get();
        
        $row = $q->row();
        return $row->mgr_id;
    }
    
    function load_emp_by_org(){
        $this->db->select('emp_num,emp_id,emp_firstname,emp_lastname');
        $this->db->from('hrms_employees');
        $this->db->where('org_id',$this->input->post('org'));
        $q = $this->db->get();
        
        return json_encode($q->result_array());
    }
    
    function load_pemeriksa_sppd(){
        $this->db->select('A.emp_num,A.emp_id,A.emp_firstname,A.emp_lastname,C.job_name,A.org_code,A.job_code,C.job_name');
        $this->db->from('flow_sppd as B');
        $this->db->join('hrms_employees as A','A.emp_num=B.emp_num','left outer');
        $this->db->join('hrms_job as C','A.emp_job=C.job_num');
        $this->db->where('B.fitur_id','3');
        $this->db->or_where('B.fitur_id','4');
        $this->db->order_by('B.flow_id',"ASC");
        $q = $this->db->get();
        return $q;
    }
    
    function load_curr_num(){
        $this->db->select('emp_start_num,emp_counter_id');
        $this->db->from('hrms_counter');
        $q = $this->db->get();
        
        $row = $q->row();
        $curr_num = $row->emp_start_num + $row->emp_counter_id;
        return $curr_num;
    }
}
