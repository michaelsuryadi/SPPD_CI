<?php

class Test extends CI_Controller {
   
    public function __construct() {
        parent::__construct();
    }
    
    function index(){
        
//        foreach ($content['pointer'] as $key=>$value){
//            echo $value->id." ".$value->name." ".$value->country.'<br/>';
//        }
        $this->load->model('test_model');
        $data['airport'] =(array) $this->test_model->get_list_airport();
        $this->load->view('test',$data);
        
    }
    function get_list_airport(){
        
    }
}
