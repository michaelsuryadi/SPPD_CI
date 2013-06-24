<?php

class Notifications extends CI_Model {
    
    function get_notifications($empnum){
        $this->db->select('A.notif_id,A.notif_desc,A.notif_link,A.notif_type,A.date_post,A.time_post,A.status,B.type_name');
        $this->db->from('hrms_notification as A');
        $this->db->join('hrms_notification_type as B','A.notif_type=B.type_id');
        $this->db->where('A.emp_num',$empnum);
        $q = $this->db->get();
        
        return $q;
    }
    
    function get_url_address($id) {
        $this->db->select('A.notif_link,B.type_url');
        $this->db->from('hrms_notification as A');
        $this->db->where('notif_id',$id);
        $this->db->join('hrms_notification_type as B','B.type_id=A.notif_type');
        $q = $this->get();
        
    }
    
}
