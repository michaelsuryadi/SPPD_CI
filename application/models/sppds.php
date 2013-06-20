<?php

class Sppds extends CI_Model {

    function get_draft_sppd($empnum) {
        $this->db->select('*');
        $this->db->from('sppd_data');
        $this->db->where('emp_id', $empnum);
        $this->db->where('sppd_status', 2);

        $query = $this->db->get();

        return $query;
    }

    function get_proses_sppd($empnum) {
        $this->db->select('*');
        $this->db->from('sppd_data');
        $this->db->where('emp_id', $empnum);
        $this->db->where('sppd_status', 1);

        $query = $this->db->get();

        return $query;
    }

    function remove($sppdnum) {
        $this->db->where('sppd_num', $sppdnum);
        $q = $this->db->delete('sppd_data');

        if ($q) {
            return true;
        } else {
            return false;
        }
    }

    function add_new_sppd() {

        $this->db->select('sppd_start_num,sppd_counter_id');
        $this->db->from('hrms_counter');
        $q4 = $this->db->get();
        $row_counter = $q4->row();
        $sppdnum = $row_counter->sppd_start_num + $row_counter->sppd_counter_id;

        $this->load->helper('date');
        $datestring = "%Y-%m-%d";
        $datestring2 = "%h:%i %a";
        $time = time();
        $tgl = mdate($datestring, $time);
        $wkt = mdate($datestring2, $time);
        $data = array(
            "sppd_id" => $sppdnum,
            "sppd_tgl" => $tgl,
            "sppd_catt" => $this->input->post('catt'),
            "sppd_dest" => $this->input->post('destination'),
            "sppd_tuj" => $this->input->post('tujuan'),
            "sppd_dsr" => $this->input->post('dasar'),
            "sppd_ket" => $this->input->post('keterangan'),
            "sppd_depart" => $this->input->post('depart'),
            "sppd_arrive" => $this->input->post('arrive'),
            "sppd_status" => $this->input->post('tipe'),
            "sppd_desc" => "tes",
            "emp_id" => $this->input->post('emp_num'),
            "emp_create_id" => $this->input->post('emp_create_id')
        );

        $q = $this->db->insert("sppd_data", $data);

        $next_counter = $row_counter->sppd_counter_id+1;
        
        $d= array("sppd_counter_id" => $next_counter);
        $this->db->update("hrms_counter",$d);
        
        
        if ($this->input->post('tipe') == '1') {
            $this->db->select("sppd_num,emp_id");
            $this->db->from("sppd_data");
            $this->db->where("sppd_id", $sppdnum);
            $q2 = $this->db->get();

            $res = $q2->row();

            $data2 = array(
                "sppd_num" => $res->sppd_num,
                "emp_num" => $res->emp_id,
                "comment" => $this->input->post('komentator'),
                "date_comment" => $tgl,
                "time_comment" => "10:00:00"
            );

            $q2 = $this->db->insert("sppd_comment", $data2);

            $pemeriksa = $this->input->post('pemeriksa');
            $count = 1;
            for ($i = 0; $i < count($pemeriksa); $i++) {
               
                    if($count==1){
                        $flag = 1;
                    }
                    
                    if($count == count($pemeriksa)){
                        $final = 1;
                    }
                    else {
                        $final=0;
                    }
                
                    $pemdata = array(
                        "sppd_num" => $res->sppd_num,
                        "emp_id" => $res->emp_id,
                        "pem_id" => $pemeriksa[$i],
                        "status" => "0",
                        "comment" => "",
                        "exam_date" => "",
                        "exam_time" => "",
                        "order" => $count,
                        "final"=>$final,
                        "flag"=>$flag
                    );
                    
                    
                    
                    
                $this->db->insert('sppd_examine', $pemdata);
                $count++;
            }

            if ($q && $q2) {
                return true;
            } else {
                return false;
            }
        }
        else {
            if($q){
                return true;
            }
            else {
                return false;
            }
        }
    }

    function list_perlu_diproses($empnum) {

        $this->db->select("A.sppd_num,B.sppd_id,A.status,C.emp_id,C.org_code,C.job_code,B.sppd_tuj,B.sppd_tgl,C.emp_firstname,C.emp_lastname, D.emp_id as pem_id,D.emp_num as pem_num, D.emp_firstname as pem_fname, D.emp_lastname as pem_lname, D.org_code as pem_org, D.job_code as pem_job");
        $this->db->from('sppd_examine as A');
        $this->db->join('sppd_data as B', 'A.sppd_num=B.sppd_num');
        $this->db->join('hrms_employees as C', 'C.emp_num=A.emp_id');
        $this->db->join('hrms_employees as D','D.emp_num=B.emp_create_id');
        $this->db->where('A.pem_id', $empnum);
        $this->db->where('flag', '1');
        $q = $this->db->get();


        return $q;
    }

    function load_data_sppd($sppdnum) {
        $this->db->select("A.sppd_num,A.sppd_id,A.sppd_tgl,A.sppd_catt,A.sppd_dest,A.sppd_tuj,A.sppd_dsr,A.sppd_ket,A.sppd_depart,A.sppd_arrive,A.sppd_status,A.sppd_desc,B.emp_num,B.emp_id,B.emp_firstname,B.emp_lastname,B.job_code,B.org_code,C.emp_id as pem_id,C.emp_firstname as pem_fname,C.emp_lastname as pem_lname,C.job_code as pem_jobcode,C.org_code as pem_orgcode");
        $this->db->from('sppd_data as A');
        $this->db->join('hrms_employees as B', 'A.emp_id=B.emp_num');
        $this->db->join('hrms_employees as C', 'A.emp_create_id=C.emp_num');
        $this->db->where('sppd_num', $sppdnum);

        $q = $this->db->get();

        return $q;
    }

    function load_comment($sppdnum) {
        $this->db->select("A.sppd_num,A.emp_num,B.emp_id,B.job_code,B.org_code,B.emp_firstname,B.emp_lastname,A.comment,A.date_comment,A.time_comment");
        $this->db->from("sppd_comment as A");
        $this->db->join("hrms_employees as B", "A.emp_num=B.emp_num");
        $this->db->where("A.sppd_num", $sppdnum);
        $this->db->order_by("A.date_comment,A.time_comment", "ASC");
        $q = $this->db->get();

        return $q;
    }

    function upd_sppd() {
        $this->load->helper('date');
        $datestring = "%Y-%m-%d";
        $time = time();
        $tgl = mdate($datestring, $time);
        $data = array(
            "status" => '1',
            "exam_date" => $tgl,
            "exam_time" => '10:00:00',
            "flag" => '0'
        );

        $this->db->where("sppd_num", $this->input->post('sppd_num'));
        $this->db->where("pem_id", $this->input->post('pem_id'));
        $q = $this->db->update("sppd_examine", $data);

        $this->db->select("order,final");
        $this->db->from("sppd_examine");
        $this->db->where("sppd_num", $this->input->post('sppd_num'));
        $this->db->where("pem_id", $this->input->post("pem_id"));
        $q = $this->db->get();
        $dat = $q->row();
        $order = $dat->order;
        $order++;

        $this->db->select("order");
        $this->db->from("sppd_examine");
        $this->db->where("sppd_num", $this->input->post('sppd_num'));
        $this->db->where("order", $order);
        $q = $this->db->get();

        if ($q->num_rows() > 0) {
            $data4 = array(
                "flag" => '1'
            );
            $this->db->where("sppd_num", $this->input->post('sppd_num'));
            $this->db->where("order", $order);
            $q2 = $this->db->update("sppd_examine", $data4);
        }
        
        if($dat->final == "1"){
            echo 'msk';
            $dta = array(
                "sppd_status"=>"3"
            );
            
            $this->db->where("sppd_num",$this->input->post('sppd_num'));
            $q3 = $this->db->update("sppd_data",$dta);
        }


        if ($q || (isset($q3) && $q3)) {
            return true;
        } else {
            return false;
        }
    }

    function get_approval($sppdnum) {
        $this->db->select("B.emp_num,B.emp_id,B.job_code,B.org_code,B.emp_firstname,B.emp_lastname,A.status,A.flag,C.job_name");
        $this->db->from("sppd_examine as A");
        $this->db->where("A.sppd_num", $sppdnum);
        $this->db->join("hrms_employees as B", "A.pem_id=B.emp_num");
        $this->db->join("hrms_job as C","B.emp_job=C.job_num");
        $this->db->order_by("A.order","ASC");
        $q = $this->db->get();

        return $q;
    }

    function send_comment_data() {

        $this->load->helper('date');
        $datestring = "%Y-%m-%d";
        $datestring2 = "%h:%i:%a";
        $time = time();
        $tgl = mdate($datestring, $time);
        $wkt = mdate($datestring2, $time);

        $data = array(
            "sppd_num" => $this->input->post('sppdnum'),
            "emp_num" => $this->input->post('empnum'),
            "comment" => $this->input->post('isi'),
            "date_comment" => $tgl,
            "time_comment" => $wkt
        );

        $q = $this->db->insert('sppd_comment', $data);

        $this->db->select('emp_firstname,emp_lastname');
        $this->db->from('hrms_employees');
        $this->db->where('emp_num', $this->input->post('empnum'));
        $q2 = $this->db->get();
        $row = $q2->row();

        if ($q) {
            return $row;
        } else {
            return false;
        }
    }
    
    function list_telah_diproses($empnum){
        $this->db->select('A.sppd_num,A.sppd_read_stat,A.sppd_id,A.sppd_tgl,A.sppd_depart,A.sppd_arrive,A.sppd_tuj,B.emp_id,B.emp_firstname,B.emp_lastname,C.emp_id as pem_id,C.emp_firstname as pem_firstname,C.emp_lastname as pem_lastname');
        $this->db->from('sppd_data as A');
        $this->db->where('A.emp_id', $empnum);
        $this->db->join('hrms_employees as B','B.emp_num=A.emp_id');
        $this->db->join('hrms_employees as C','C.emp_num=A.emp_create_id');
        $this->db->where('sppd_status', 3); 
        $query = $this->db->get();

        return $query;
    
    }
}
