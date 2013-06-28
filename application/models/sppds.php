<?php

class Sppds extends CI_Model {

    var $gallery_path;
    var $gallery_path_url;

    public function __construct() {
        parent::__construct();

        $this->gallery_path = realpath(APPPATH . '../images');
        $this->gallery_path_url = base_url() . 'images/';
    }

    /*
     * function untuk menampilkan seluruh draft sppd
     * sesuai dengan pemohon / user yang sedang aktif
     * 
     * 
     */

    function get_draft_sppd($empnum) {
        $this->db->select('A.sppd_id,A.sppd_num,A.sppd_tgl,A.sppd_tuj,B.emp_id,B.emp_firstname,B.emp_lastname, C.emp_id as pem_id, C.emp_firstname as pem_fname, C.emp_lastname as pem_lname');
        $this->db->from('sppd_data as A');
        $this->db->where('A.emp_id', $empnum);
        $this->db->where('A.sppd_status', 2);
        $this->db->join('hrms_employees as B', 'A.emp_id=B.emp_num');
        $this->db->join('hrms_employees as C', 'A.emp_create_id=C.emp_num');
        $this->db->limit(4, 0);
        $this->db->order_by('A.sppd_id', 'DESC');
        $query = $this->db->get();

        return $query;
    }

    /*
     * Menampilkan seluruh sppd yang perlu di proses oleh pemeriksa
     * 
     */

    function get_proses_sppd($empnum) {
        $this->db->select('A.sppd_num,A.sppd_id,A.sppd_tgl,A.sppd_tuj,B.emp_id,B.emp_firstname,B.emp_lastname, C.emp_id as pem_id, C.emp_firstname as pem_fname, C.emp_lastname as pem_lname,E.emp_firstname as curr_fname,E.emp_lastname as curr_lname,E.emp_id as curr_empid,D.order');
        $this->db->from('sppd_data as A');
        $this->db->where('A.emp_id', $empnum);
        $this->db->join('hrms_employees as B', 'A.emp_id=B.emp_num');
        $this->db->join('hrms_employees as C', 'A.emp_create_id=C.emp_num');
        $this->db->join('sppd_examine as D', 'D.sppd_num=A.sppd_num');
        $this->db->join('hrms_employees as E', 'E.emp_num=D.pem_id');
        $this->db->where('D.flag', '1');
        $this->db->where('D.status', '0');
        $this->db->where('A.sppd_status', 1);
        $this->db->order_by('A.sppd_num', 'DESC');

        $hasil = array();
        $query = $this->db->get();
        $hasil[] = $query;
//        foreach($query->result() as $row){
//            if($row->order !=1){
//                $order = $row->order;
//                $order--;
//                $this->db->select('B.emp_id,B.emp_firstname,B.emp_lastname');
//                $this->db->from('sppd_examine as A');
//                $this->db->join('hrms_employees as B','B.emp_num=A.emp_id');
//                $this->db->where('A.sppd_num',$row->sppd_num);
//                $this->db->where('A.order',$order);
//                
//                $hasil[] = $this->db->get();
//            }
//        }

        return $hasil;
    }

    /*
     * Function untuk menghapus draft SPPD yang dibuat
     * 
     */

    function remove($sppdnum) {
        $this->db->where('sppd_num', $sppdnum);
        $q = $this->db->delete('sppd_data');

        if ($q) {
            return true;
        } else {
            return false;
        }
    }

    /*
     * Function untuk meng-create SPPD baru
     * 
     */

    function add_new_sppd() {

        $this->db->select('sppd_start_num,sppd_counter_id');
        $this->db->from('hrms_counter');
        $q4 = $this->db->get();
        $row_counter = $q4->row();
        $sppdnum = $row_counter->sppd_start_num + $row_counter->sppd_counter_id;

        $time = time();
        date_default_timezone_set('Asia/Jakarta');
        $tgl = date("Y-m-d H:i:s", $time);
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

        $next_counter = $row_counter->sppd_counter_id + 1;

        $d = array("sppd_counter_id" => $next_counter);
        $this->db->update("hrms_counter", $d);

        $config = array(
            'allowed_types' => 'jpg|jpeg|gif|png',
            'upload_path' => $this->gallery_path,
            'max_size' => 2000
        );

        $this->load->library('upload', $config);
        $this->upload->do_upload();
        $image_data = $this->upload->data();
        $this->db->select("sppd_num,sppd_id,emp_id");
        $this->db->from("sppd_data");
        $this->db->where("sppd_id", $sppdnum);
        $q2 = $this->db->get();

        $res = $q2->row();
        if ($this->input->post('tipe') == '1') {


            $data2 = array(
                "sppd_num" => $res->sppd_num,
                "emp_num" => $res->emp_id,
                "comment" => 'Submit - '-$this->input->post('komentator'),
                "date_comment" => $tgl
            );

            $q2 = $this->db->insert("sppd_comment", $data2);

            $pemeriksa = $this->input->post('pemeriksa');
            $count = 1;
            for ($i = 0; $i < count($pemeriksa); $i++) {

                if ($count == 1) {
                    $flag = 1;
                } else {
                    $flag = 0;
                }

                if ($count == count($pemeriksa)) {
                    $final = 1;
                } else {
                    $final = 0;
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
                    "final" => $final,
                    "flag" => $flag,
                    "send_status" => "1"
                );

                $this->db->insert('sppd_examine', $pemdata);

                if ($count == 1) {
                    $time = time();
                    date_default_timezone_set('Asia/Jakarta');
                    $tgl = date("Y-m-d H:i:s", $time);

                    $data5 = array(
                        "notif_desc" => "SPPD Dengan ID " . $res->sppd_id . " Perlu Diproses",
                        "notif_link" => $res->sppd_num,
                        "notif_type" => "1",
                        "date_post" => $tgl,
                        "emp_num" => $pemeriksa[$i]
                    );

                    $this->db->insert('hrms_notification', $data5);
                }

                $count++;
            }

            $this->send_comment_data();


            if ($q && $q2) {
                return true;
            } else {
                return false;
            }
        } else {

            $pemeriksa = $this->input->post('pemeriksa');
            $count = 1;
            for ($i = 0; $i < count($pemeriksa); $i++) {

                if ($count == 1) {
                    $flag = 1;
                } else {
                    $flag = 0;
                }

                if ($count == count($pemeriksa)) {
                    $final = 1;
                } else {
                    $final = 0;
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
                    "final" => $final,
                    "flag" => $flag,
                    "send_status" => "0"
                );

                $this->db->insert('sppd_examine', $pemdata);
                $count++;
            }
            if ($q) {
                return true;
            } else {
                return false;
            }
        }
    }

    /*
     * Untuk menampilkan list SPPD yang perlu di proses
     */

    function list_perlu_diproses($empnum) {

        $this->db->select("A.sppd_num,B.sppd_id,A.status,C.emp_id,C.org_code,C.job_code,B.sppd_tuj,B.sppd_tgl,C.emp_firstname,C.emp_lastname, D.emp_id as pem_id,D.emp_num as pem_num, D.emp_firstname as pem_fname, D.emp_lastname as pem_lname, D.org_code as pem_org, D.job_code as pem_job");
        $this->db->from('sppd_examine as A');
        $this->db->join('sppd_data as B', 'A.sppd_num=B.sppd_num');
        $this->db->join('hrms_employees as C', 'C.emp_num=A.emp_id');
        $this->db->join('hrms_employees as D', 'D.emp_num=B.emp_create_id');
        $this->db->where('A.pem_id', $empnum);
        $this->db->where('A.flag', '1');
        $this->db->where('A.send_status', '1');
        $q = $this->db->get();

        return $q;
    }

    /*
     * Untuk menampilkan data-data yang terdapat di SPPD
     * $sppdnum : sppd number
     */

    function load_data_sppd($sppdnum) {
        $this->db->select("A.sppd_num,A.sppd_id,A.sppd_tgl,A.sppd_catt,A.sppd_dest,A.sppd_tuj,A.sppd_dsr,A.sppd_ket,A.sppd_depart,A.sppd_arrive,A.sppd_status,A.sppd_desc,B.emp_num,B.emp_id,B.emp_firstname,B.emp_lastname,B.job_code,B.org_code,C.emp_id as pem_id,C.emp_firstname as pem_fname,C.emp_lastname as pem_lname,C.job_code as pem_jobcode,C.org_code as pem_orgcode");
        $this->db->from('sppd_data as A');
        $this->db->join('hrms_employees as B', 'A.emp_id=B.emp_num');
        $this->db->join('hrms_employees as C', 'A.emp_create_id=C.emp_num');
        $this->db->where('sppd_num', $sppdnum);

        $q = $this->db->get();

        return $q;
    }

    /*
     * Menampilkan list pemeriksa dari suatu SPPD
     * $sppdnum = sppd number
     */

    function load_pemeriksa_sppd($sppdnum) {
        $this->db->select("A.emp_num,A.emp_id, A.emp_firstname,A.emp_lastname,A.job_code,A.org_code,C.job_name");
        $this->db->from("sppd_examine as B");
        $this->db->where('B.sppd_num', $sppdnum);
        $this->db->join('hrms_employees as A', 'A.emp_num=B.pem_id');
        $this->db->join('hrms_job as C', 'A.emp_job=C.job_num');
        $this->db->order_by('B.order', 'ASC');
        $q = $this->db->get();

        return $q;
    }

    /*
     * Menampilkan komentar-komentar yang pernah ditulis oleh pemeriksa
     * atau pemohon
     * $sppdnum = sppd number
     */

    function load_comment($sppdnum) {
        $this->db->select("A.sppd_num,A.emp_num,B.emp_id,B.job_code,B.org_code,B.emp_firstname,B.emp_lastname,A.comment,A.date_comment,A.time_comment");
        $this->db->from("sppd_comment as A");
        $this->db->join("hrms_employees as B", "A.emp_num=B.emp_num");
        $this->db->where("A.sppd_num", $sppdnum);
        $this->db->order_by("A.date_comment,A.time_comment", "ASC");
        $q = $this->db->get();

        return $q;
    }

    /*
     * Mengupdate current pemeriksa sesuai dengan urutan
     */

    function upd_sppd() {
        $this->load->helper('date');
        $datestring = "%Y-%m-%d";
        $time = time();
        $tgl = mdate($datestring, $time);
        date_default_timezone_set("Asia/Jakarta");
        $jam = date("H:i:s", $time);

        $data = array(
            "status" => '1',
            "exam_date" => $tgl,
            "exam_time" => $jam,
            "flag" => '0'
        );

        $this->db->where("sppd_num", $this->input->post('sppd_num'));
        $this->db->where("pem_id", $this->input->post('pem_id'));
        $q = $this->db->update("sppd_examine", $data);

        $this->db->select("sppd_num,sppd_id,emp_id");
        $this->db->from("sppd_data");
        $this->db->where("sppd_num", $this->input->post('sppd_num'));
        $q6 = $this->db->get();
        $rowsppd = $q6->row();

        $this->db->select("order,final");
        $this->db->from("sppd_examine");
        $this->db->where("sppd_num", $this->input->post('sppd_num'));
        $this->db->where("pem_id", $this->input->post("pem_id"));
        $q = $this->db->get();
        $dat = $q->row();
        $order = $dat->order;
        $order++;

        $this->db->select("order,pem_id,emp_id");
        $this->db->from("sppd_examine");
        $this->db->where("sppd_num", $this->input->post('sppd_num'));
        $this->db->where("order", $order);
        $q = $this->db->get();
        $rowexam = $q->row();

        $this->db->select('sppd_id');
        $this->db->from('sppd_data');
        $this->db->where('sppd_num', $this->input->post('sppd_num'));
        $sppdId = $this->db->get()->row()->sppd_id;

        if ($q->num_rows() > 0) {
            $data4 = array(
                "flag" => '1'
            );
            $this->db->where("sppd_num", $this->input->post('sppd_num'));
            $this->db->where("order", $order);
            $q2 = $this->db->update("sppd_examine", $data4);
            $datestring = "%Y-%m-%d";
            $time = time();
            $tgl = mdate($datestring, $time);

            date_default_timezone_set("Asia/Jakarta");
            $date_post = date("Y-m-d H:i:s");

            $data5 = array(
                "notif_desc" => "SPPD Dengan ID " . $sppdId . " Perlu Diproses",
                "notif_link" => $this->input->post('sppd_num'),
                "notif_type" => "1",
                "date_post" => $date_post,
                "emp_num" => $rowexam->pem_id
            );

            $this->db->insert('hrms_notification', $data5);
        }

        if ($dat->final == "1") {
            $dta = array(
                "sppd_status" => "3"
            );

            $this->db->where("sppd_num", $this->input->post('sppd_num'));
            $q3 = $this->db->update("sppd_data", $dta);

            $this->db->select("emp_id");
            $this->db->from("sppd_examine");
            $this->db->where("final", "1");
            $this->db->where("sppd_num", $this->input->post('sppd_num'));
            $q4 = $this->db->get()->row();

            $datestring = "%Y-%m-%d";
            $time = time();

            date_default_timezone_set("Asia/Jakarta");
            $date_post = date("Y-m-d H:i:s");

            $data5 = array(
                "notif_desc" => "SPPD Dengan ID " . $sppdId . " Telah Selesai",
                "notif_link" => $this->input->post('sppd_num'),
                "notif_type" => "2",
                "date_post" => $date_post,
                "emp_num" => $q4->emp_id
            );

            $this->db->insert('hrms_notification', $data5);

            
        }
        date_default_timezone_set("Asia/Jakarta");
        $today = date("Y-m-d H:i:s");

        $data = array(
            "sppd_num" => $this->input->post('sppd_num'),
            "emp_num" => $this->input->post('pem_id'),
            "comment" => 'Approve - '.$this->input->post('komentator'),
            "date_comment" => $today
        );

        $q = $this->db->insert('sppd_comment', $data);

        if ($q || (isset($q3) && $q3)) {
            return true;
        } else {
            return false;
        }
    }

    /*
     * Menampilkan status approval dari pemeriksa terhadap sppd
     * 
     */

    function get_approval($sppdnum) {
        $this->db->select("B.emp_num,B.emp_id,B.job_code,B.org_code,B.emp_firstname,B.emp_lastname,A.status,A.flag,C.job_name");
        $this->db->from("sppd_examine as A");
        $this->db->where("A.sppd_num", $sppdnum);
        $this->db->join("hrms_employees as B", "A.pem_id=B.emp_num");
        $this->db->join("hrms_job as C", "B.emp_job=C.job_num");
        $this->db->order_by("A.order", "ASC");
        $q = $this->db->get();

        return $q;
    }

    /*
     * Function untuk mengirimkan komentar yang ditulis oleh pemohon/pemeriksa sppd
     */

    function send_comment_data() {

        date_default_timezone_set("Asia/Jakarta");
        $today = date("Y-m-d H:i:s");

        $data = array(
            "sppd_num" => $this->input->post('sppdnum'),
            "emp_num" => $this->input->post('empnum'),
            "comment" => $this->input->post('isi'),
            "date_comment" => $today
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

    /*
     * Function untuk menampilkan list sppd yang telah selesai di proses
     */

    function list_telah_diproses($empnum) {
        $this->db->select('A.sppd_num,A.sppd_read_stat,A.sppd_id,A.sppd_tgl,A.sppd_depart,A.sppd_arrive,A.sppd_tuj,B.emp_id,B.emp_firstname,B.emp_lastname,C.emp_id as pem_id,C.emp_firstname as pem_fname,C.emp_lastname as pem_lname');
        $this->db->from('sppd_data as A');
        $this->db->where('A.emp_id', $empnum);
        $this->db->join('hrms_employees as B', 'B.emp_num=A.emp_id');
        $this->db->join('hrms_employees as C', 'C.emp_num=A.emp_create_id');
        $this->db->where('sppd_status', 3);
        $query = $this->db->get();

        return $query;
    }

    /*
     * Function untuk memproses sppd yang di reject
     */

    function reject_sppd() {

        $this->db->select('emp_id');
        $this->db->from('hrms_user');
        $this->db->where('emp_username', $this->session->userdata('username'));

        $q = $this->db->get();
        $rowuser = $q->row();
        $emp_id = $rowuser->emp_id;

        $data = array(
            "flag" => "0"
        );

        $this->db->where('sppd_num', $this->input->post('sppd_num'));
        $this->db->where('pem_id', $emp_id);
        $this->db->update('sppd_examine', $data);


        $this->db->select('order');
        $this->db->from('sppd_examine');
        $this->db->where('sppd_num', $this->input->post('sppd_num'));
        $this->db->where('pem_id', $emp_id);
        $q2 = $this->db->get();

        $rowpem = $q2->row();
        $order = $rowpem->order;

        if ($order != 1) {
            $order--;

            $data = array(
                "flag" => "1",
                "status" => "0"
            );

            $this->db->where('order', $order);
            $this->db->where('sppd_num', $this->input->post('sppd_num'));
            $this->db->update('sppd_examine', $data);
        } else {



            $this->db->where('sppd_num', $this->input->post('sppd_num'));
            $this->db->update('sppd_examine', $data2);
        }
        return true;
    }

    function process_edit() {
        $data = array(
            "emp_id" => $this->input->post('emp_num'),
            "sppd_dest" => $this->input->post('destination'),
            "sppd_depart" => $this->input->post('depart'),
            "sppd_arrive" => $this->input->post('arrive'),
            "sppd_ket" => $this->input->post('keterangan'),
            "sppd_dsr" => $this->input->post('dasar'),
            "sppd_tuj" => $this->input->post('tujuan'),
            "sppd_catt" => $this->input->post('catt')
        );

        $this->db->where('sppd_num', $this->input->post('sppd_id'));
        $this->db->update('sppd_data', $data);

        if ($this->input->post('tipe') == 1) {
            $data2 = array(
                "sppd_status" => '1'
            );

            $this->db->where('sppd_num', $this->input->post('sppd_id'));
            $this->db->update('sppd_data', $data2);

            $data3 = array(
                "send_status" => '1'
            );

            $this->db->where('sppd_num', $this->input->post('sppd_id'));
            $this->db->update('sppd_examine', $data3);

            $data4 = array(
                'flag' => '1'
            );

            $this->db->where('sppd_num', $this->input->post('sppd_id'));
            $this->db->where('order', '1');
            $this->db->update('sppd_examine', $data4);

            $this->db->select('pem_id');
            $this->db->from('sppd_examine');
            $this->db->where('order', '1');
            $this->db->where('sppd_num', $this->input->post('sppd_id'));
            $pemid = $this->db->get()->row()->pem_id;
            
            $this->db->select('sppd_id');
            $this->db->from('sppd_data');
            $this->db->where('sppd_num',$this->input->post('sppd_id'));
            $sppdid = $this->db->get()->row()->sppd_id;

            $time = time();
            date_default_timezone_set('Asia/Jakarta');
            $tgl = date("Y-m-d H:i:s", $time);

            $data5 = array(
                "notif_desc" => "SPPD Dengan ID " . $sppdid . " Perlu Diproses",
                "notif_link" => $this->input->post('sppd_id'),
                "notif_type" => "1",
                "date_post" => $tgl,
                "emp_num" => $pemid
            );

            $this->db->insert('hrms_notification', $data5);
        }

        return true;
    }

}
