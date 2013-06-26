<?php

class Reservation_model extends CI_Model {
    
    function get_list_airport(){
        $url = "http://login.pointer.co.id/api/airport/get/format/json";
        $params = array(
            'token'=>$this->token
        );
        
        $json_result = json_decode($this->post($url,$params));
        $return=$json_result;
        if ($json_result != null && $json_result->status != null && $json_result->status->Code == "200") {
            $json_airport = $json_result->pointer[0];
            $return=$json_airport;
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
                        'Content-Length: '.strlen($post)
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
}
