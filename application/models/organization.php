<?php

class Organization extends CI_Model {
    
    /*
     * Function untuk menampilkan seluruh organization
     */
    function get_all_org(){
        return $this->db->get('hrms_organization');
    }
    
    /*
     * function untuk menampilkan organization code
     */
    function get_org_code($orgnum){
        $this->db->select('org_code');
        $this->db->from('hrms_organization');
        $this->db->where('org_num',$orgnum);
        $q = $this->db->get();
        
        $row = $q->row();
        
        return $row->org_code;
    }
}
