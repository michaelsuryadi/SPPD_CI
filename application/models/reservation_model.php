<?php

class Reservation_model extends CI_Model {

    function get_list_airport() {
        $url = "http://login.pointer.co.id/api/airport/get/format/json";
        $params = array(
            'token' => $this->token
        );

        $json_result = json_decode($this->post($url, $params));
        $return = $json_result;
        if ($json_result != null && $json_result->status != null && $json_result->status->Code == "200") {
            $json_airport = $json_result->pointer[0];
            $return = $json_airport;
        }
        echo $return;
    }

    function post($url, $params) {
        try {
            $post = json_encode($params);

            $this->curl->create($url);
            $this->curl->options(
                    array(
                        CURLOPT_BUFFERSIZE => 128,
                        CURLOPT_HTTPHEADER => array(
                            'Content-Type: application/x-www-form-urlencoded',
                            'Content-Length: ' . strlen($post)
                        )
                    )
            );
            $this->curl->post($post);
            $result = $this->curl->execute();

            return $result;
        } catch (Exception $e) {
            return null;
        }
    }

    function process_req() {

        $time = time();
        date_default_timezone_set('Asia/Jakarta');
        $tgl = date("Y-m-d H:i:s", $time);
        
        $data = array(
            "sppd_num" => $this->input->post('sppdnum'),
            "flight_desc" => $this->input->post('flight'),
            "time_desc" => $this->input->post('time'),
            "hotel_desc" => $this->input->post('hotel'),
            "send_date" =>$tgl,
            "status" => "1"
        );
        $q = $this->db->insert('reservation_req', $data);
        if ($q) {
            return true;
        } else {
            return false;
        }
    }
    
    function get_all_reservation_req(){
        $this->db->select('A.req_id,A.send_date,A.sppd_num,A.flight_desc,A.time_desc,A.hotel_desc,A.status,C.emp_id,B.sppd_dest,B.sppd_depart,B.sppd_arrive,C.emp_id,C.emp_firstname,C.emp_lastname,D.job_name');
        $this->db->from('reservation_req as A');
        $this->db->join('sppd_data as B','A.sppd_num=B.sppd_num');
        $this->db->join('hrms_employees as C','B.emp_id = C.emp_num');
        $this->db->join('hrms_job as D','C.emp_job=D.job_num');
        $q = $this->db->get();
        
        return $q;
    }
    
    function load_request(){
        $this->db->select('flight_desc,time_desc,hotel_desc');
        $this->db->from('reservation_req');
        $this->db->where('req_id',$this->input->post('req_id'));
        $q = $this->db->get();
        
        $row = $q->row();
        
        echo $row->flight_desc.'!@#'.$row->time_desc.'!@#'.$row->hotel_desc;
    }

}
