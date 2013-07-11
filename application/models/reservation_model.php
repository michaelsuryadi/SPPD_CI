<?php

class Reservation_model extends CI_Model {

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
            "send_date" => $tgl,
            "status" => "1"
        );
        $q = $this->db->insert('reservation_req', $data);

        $data2 = array(
            "reserve_status" => "1"
        );
        $this->db->where('sppd_num', $this->input->post('sppdnum'));
        $q2 = $this->db->update('sppd_data', $data2);

        if ($q && $q2) {
            return true;
        } else {
            return false;
        }
    }

    function get_all_reservation_req() {
        $this->db->select('A.req_id,A.send_date,A.sppd_num,A.flight_desc,A.time_desc,A.hotel_desc,A.status,C.emp_id,B.sppd_dest,B.sppd_depart,B.sppd_arrive,C.emp_id,C.emp_firstname,C.emp_lastname,D.job_name');
        $this->db->from('reservation_req as A');
        $this->db->join('sppd_data as B', 'A.sppd_num=B.sppd_num');
        $this->db->join('hrms_employees as C', 'B.emp_id = C.emp_num');
        $this->db->join('hrms_job as D', 'C.emp_job=D.job_num');
        $q = $this->db->get();

        return $q;
    }

    function load_request() {
        $this->db->select('A.flight_desc,A.time_desc,A.hotel_desc,B.sppd_num,B.emp_id,B.sppd_id,B.sppd_tuj');
        $this->db->from('reservation_req as A');
        $this->db->join('sppd_data as B', 'A.sppd_num=B.sppd_num');
        $this->db->where('req_id', $this->input->post('req_id'));
        $q = $this->db->get();

        $row = $q->row();

        echo $row->flight_desc . '!@#' . $row->time_desc . '!@#' . $row->hotel_desc . '!@#' . $row->sppd_id . '!@#' . $row->sppd_tuj;
    }

    function load_request_data($sppdnum) {
        $this->db->select('flight_desc,time_desc,hotel_desc,send_date');
        $this->db->from('reservation_req');
        $this->db->where('sppd_num', $sppdnum);
        $q = $this->db->get();

        return $q;
    }

    function get_web_page() {

        $url = "http://login.pointer.co.id/api/airport/get/format/json";
        $options = array(
            CURLOPT_HTTPAUTH => CURLAUTH_DIGEST,
            CURLOPT_USERPWD => 'demo@pointer.co.id:oBZBG0worRFP',
            CURLOPT_HTTPHEADER => array('MARS-API-KEY: cce893e203a9ec54c989ec5e29559588'),
            CURLOPT_RETURNTRANSFER => '1'
        );

        $ch = curl_init($url);

        curl_setopt_array($ch, $options);
        $return = "";
        $content = json_decode(curl_exec($ch));

        curl_close($ch);
        return $content;
    }

    function get_web_page_2() {
        $url = "http://login.pointer.co.id/api/airlines/check/format/json";
        $options = array(
            CURLOPT_POST => "1",
            CURLOPT_POSTFIELDS => "from_city=jog&to_city=dps",
            CURLOPT_HTTPAUTH => CURLAUTH_DIGEST,
            CURLOPT_USERPWD => 'demo@pointer.co.id:oBZBG0worRFP',
            CURLOPT_HTTPHEADER => array('MARS-API-KEY: cce893e203a9ec54c989ec5e29559588'),
            CURLOPT_RETURNTRANSFER => '1'
        );

        $ch = curl_init($url);

        curl_setopt_array($ch, $options);
        $return = "";
        $content = json_decode(curl_exec($ch));

        curl_close($ch);
        return $content;
    }

    function get_detail_reservation($reqid) {
        $this->db->select('A.req_id,A.flight_desc,A.time_desc,A.hotel_desc,A.send_date,B.sppd_tuj,B.sppd_dest,B.sppd_depart,B.sppd_num,C.emp_num,B.sppd_arrive,B.sppd_tgl,B.sppd_id,C.emp_id,C.emp_firstname,C.emp_lastname,C.org_code,C.job_code');
        $this->db->from('reservation_req as A');
        $this->db->join('sppd_data as B', 'A.sppd_num=B.sppd_num');
        $this->db->join('hrms_employees as C', 'B.emp_id=C.emp_num');
        $this->db->where('A.req_id', $reqid);

        $q = $this->db->get();

        return $q;
    }

    function get_list_airport() {

        $url = "http://login.pointer.co.id/api/airport/get/format/json";
        $options = array(
            CURLOPT_HTTPAUTH => CURLAUTH_DIGEST,
            CURLOPT_USERPWD => 'demo@pointer.co.id:oBZBG0worRFP',
            CURLOPT_HTTPHEADER => array('MARS-API-KEY: cce893e203a9ec54c989ec5e29559588'),
            CURLOPT_RETURNTRANSFER => '1'
        );

        $ch = curl_init($url);

        curl_setopt_array($ch, $options);

        $content = curl_exec($ch);
        $arr = json_decode($content);
        curl_close($ch);

        return $arr;
    }

    function get_available_airline() {
        $url = "http://login.pointer.co.id/api/airlines/check/format/json";
        $from = $this->input->post('from_city');
        $to = $this->input->post('to_city');
        $options = array(
            CURLOPT_POST => "1",
            CURLOPT_POSTFIELDS => "from_city=" . $from . "&to_city=" . $to,
            CURLOPT_HTTPAUTH => CURLAUTH_DIGEST,
            CURLOPT_USERPWD => 'demo@pointer.co.id:oBZBG0worRFP',
            CURLOPT_HTTPHEADER => array('MARS-API-KEY: cce893e203a9ec54c989ec5e29559588'),
            CURLOPT_RETURNTRANSFER => '1'
        );
        $ch = curl_init($url);
        curl_setopt_array($ch, $options);
        
        $content = curl_exec($ch);
        $arr = json_decode($content);
        $data = $arr->airlines;
        $content2 = json_encode($data);
        curl_close($ch);

        return $content2;
    }
    
    function search_flight(){
        $url ="http://login.pointer.co.id/api/flight/check/format/json";
        
        $airline = $this->input->post('airline');
        $from_city = $this->input->post('from_city');
        $to_city = $this->input->post('to_city');
        $tgl_flight = $this->input->post('tgl_flight');
        $jml_penumpang = $this->input->post('jml_penumpang');
        $jml_children = $this->input->post('jml_children');
        $jml_infant = $this->input->post('jml_infant');
        
        
        $options = array(
            CURLOPT_POST => "1",
            CURLOPT_POSTFIELDS => "airline=".$airline."&from_city=" .$from_city ."&to_city=" . $to_city."&tgl_flight=".$tgl_flight."&jml_penumpang=".$jml_penumpang."&jml_children=".$jml_children."&jml_infant=".$jml_infant,
            CURLOPT_HTTPAUTH => CURLAUTH_DIGEST,
            CURLOPT_USERPWD => 'demo@pointer.co.id:oBZBG0worRFP',
            CURLOPT_HTTPHEADER => array('MARS-API-KEY: cce893e203a9ec54c989ec5e29559588'),
            CURLOPT_RETURNTRANSFER => '1'
        );
//        $options = array(
//            CURLOPT_POST => "1",
//            CURLOPT_POSTFIELDS => "airline="."lionair"."&from_city=" . "BDO". "&to_city=" . "DPS"."&tgl_flight="."20/07/2013"."&jml_penumpang="."1"."&jml_children="."0"."&jml_infant="."0",
//            CURLOPT_HTTPAUTH => CURLAUTH_DIGEST,
//            CURLOPT_USERPWD => 'demo@pointer.co.id:oBZBG0worRFP',
//            CURLOPT_HTTPHEADER => array('MARS-API-KEY: cce893e203a9ec54c989ec5e29559588')
//        );
        
        $ch = curl_init($url);

        curl_setopt_array($ch, $options);
        $content = curl_exec($ch);
        $data= (array)json_decode($content);
        
        $content2 = json_encode($data);
        curl_close($ch);
        
        return $content2;
    }
    
    function get_list_country(){
        $url = "http://labs.pointer.co.id/api/hotel/country/format/json";
        $options = array(
            CURLOPT_POST => "1",
            CURLOPT_HTTPAUTH => CURLAUTH_DIGEST,
            CURLOPT_USERPWD => 'demo@pointer.co.id:oBZBG0worRFP',
            CURLOPT_HTTPHEADER => array('MARS-API-KEY: cce893e203a9ec54c989ec5e29559588'),
            CURLOPT_RETURNTRANSFER => '1'
        );
        $ch = curl_init($url);

        curl_setopt_array($ch, $options);
        
        $content = curl_exec($ch);
        $arr = (array)json_decode($content);
        curl_close($ch);
        
        return $arr->Countries;
    }
    
    function get_list_city(){
        $url = "http://labs.pointer.co.id/api/hotel/city/format/json";
        $id_country = $this->input->post('id_country');
        $options = array(
            CURLOPT_POST => "1",
            CURLOPT_POSTFIELDS => "id_country=".$id_country,
            CURLOPT_HTTPAUTH => CURLAUTH_DIGEST,
            CURLOPT_USERPWD => 'demo@pointer.co.id:oBZBG0worRFP',
            CURLOPT_HTTPHEADER => array('MARS-API-KEY: cce893e203a9ec54c989ec5e29559588'),
            CURLOPT_RETURNTRANSFER => '1'
        );
        $ch = curl_init($url);

        curl_setopt_array($ch, $options);
        
        $content = curl_exec($ch);
        $arr = json_decode($content);
        
        curl_close($ch);
        
        return $arr;
    }
    
    function get_build_pnr(){
        $url = "http://login.pointer.co.id/api/flight/buildpnr/format/json";
        $ftid = $this->input->post('ftid');
        
        $options = array(
            CURLOPT_POST => "1",
            CURLOPT_POSTFIELDS => "ftid=".$ftid,
            CURLOPT_HTTPAUTH => CURLAUTH_DIGEST,
            CURLOPT_USERPWD => 'demo@pointer.co.id:oBZBG0worRFP',
            CURLOPT_HTTPHEADER => array('MARS-API-KEY: cce893e203a9ec54c989ec5e29559588'),
            CURLOPT_RETURNTRANSFER => '1'
        );
        $ch = curl_init($url);

        curl_setopt_array($ch, $options);
        
        $content = curl_exec($ch);
        $arr = json_decode($content);
        $data = $arr->flight;
        $content2 = json_encode($data);
        
        curl_close($ch);
        
        return $content2;
    }
    
    function process_booking(){
        $url = "http://login.pointer.co.id/api/flight/book/format/json/";
        
        $ftid = $this->input->post('ftid');
        $titleadlt = $this->input->post('titleadlt');
        $firstnameadlt = $this->input->post('firstnameadlt');
        $lastnameadlt = $this->input->post('lastnameadlt');
        $contacttitle = $this->input->post('contacttitle');
        $contactfirstname = $this->input->post('contactfirstname');
        $contactlastname = $this->input->post('contactlastname');
        $countrycode = $this->input->post('countrycode');
        $contactphone = $this->input->post('contactphone');
        $reqid = $this->input->post('reqid');
        $empnum = $this->input->post('empnum');
        
        $options = array(
            CURLOPT_POST => "1",
            CURLOPT_POSTFIELDS => "ftid=".$ftid."&titleadlt1=".$titleadlt."&firstnameadlt1=".$firstnameadlt."&lastnameadlt1=".$lastnameadlt."&contacttitle=".$contacttitle."&contactfirstname=".$contactfirstname."&contactlastname=".$contactlastname."&countrycode=".$countrycode."&contactphone=".$contactphone,
            CURLOPT_HTTPAUTH => CURLAUTH_DIGEST,
            CURLOPT_USERPWD => 'demo@pointer.co.id:oBZBG0worRFP',
            CURLOPT_HTTPHEADER => array('MARS-API-KEY: cce893e203a9ec54c989ec5e29559588'),
            CURLOPT_RETURNTRANSFER => '1'
        );
        $ch = curl_init($url);

        curl_setopt_array($ch, $options);
        
        $content = curl_exec($ch);
        
        curl_close($ch);
        $data = json_decode($content);
        $booking_id = $data->flight->booking_code;
        $datetime_limit = $data->flight->date_limit." ".$data->flight->time_limit;
        
        $time = time();
        date_default_timezone_set('Asia/Jakarta');
        $today = date("Y-m-d H:i:s", $time);
        
        $data2 = array(
            "req_id"=>$reqid,
            "emp_num"=>$empnum,
            "res_type"=>'1',
            "booking_id"=> $booking_id,
            "booking_date"=> $today,
            "limit_date"=>$datetime_limit,
            "status"=>'1'
        );
        
        $this->db->insert('reservation_data',$data2);
        
        return $content;
    }
    
    function get_list_booking($sppdnum){
        $this->db->select("*");
        $this->db->from('reservation_data');
        $this->db->where('req_id',$sppdnum);
        
        $q = $this->db->get();
        
        return $q;
    }

}
