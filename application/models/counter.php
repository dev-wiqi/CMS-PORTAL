<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class counter extends CI_Model {
    /*
     * SamMarie Application V.1.0 Copyright 2014
     * Build Date : 17 Juli 2014
     * Founder & Programmer : Wisnu Groho Aji 
     * Website : http://wiqi.co
     */
    
   
    function __construct() {
        $this->db = $this->load->database("default", TRUE);
        $this->load->library("user_agent");
        $this->ip = $this->input->ip_address();
        $this->date = date("d-m-Y");
        $this->browser = $this->agent->agent_string();
    }
    
    function check_expire(){
        $where['tb_ip_visitor'] = $this->ip;
        $where['tb_date_visitor'] = $this->date;
        $query = $this->db->get("wq_visitor",$where);
          if (($query->num_rows()) > 0){
              return FALSE;
          }
          else{
              return TRUE;
          }
    }
    
    function insert_visitor(){
        if(check_expire($this->ip,$this->date)){
            $insert['tb_ip_visitor'] = $this->ip;
            $insert['tb_date_visitor'] = $this->date;
            $insert['tb_browser_visitor'] = $this->browser;
            $this->db->insert("wq_visitor",$insert);
        }
    }
    
    function counter(){
        return $this->db->count_all('wq_visitor');
    }
}