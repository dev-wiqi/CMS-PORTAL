<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class home extends MX_Controller {

    private $perm_user;
    private $logged_in;
    /*
     * SamMarie Application V.1.0 Copyright 2014
     * Build Date : 17 Juli 2014
     * Founder & Programmer : Wisnu Groho Aji 
     * Website : http://wiqi.co
     */
    
    function __construct() {
        parent::__construct();
        $this->logged_in=$this->encrypt->decode($this->session->userdata("log_in"));
        $this->perm_user=$this->encrypt->decode($this->session->userdata("permission"));
    }
    
    public function index(){
        $this->is_admin;
        $a['title'] = "SamMarie Application";
        $a['permission'] = $this->perm_user;
        $a['mweb'] = $this->models_admin->menu("web",$this->perm_user);
        $a['mblog'] = $this->models_admin->menu("blog",$this->perm_user);
        $a['madmin'] = $this->models_admin->menu("admin",$this->perm_user);
        $a['mproducts'] = $this->models_admin->menu("products",$this->perm_user);
        $a['profile'] = $this->models_admin->profile_top($this->session->userdata("id_user"));
        $a['content'] = $this->models_admin->content('blog');
        $a['usr'] = $this->session->userdata("username");
        
       
        $this->load->view("basic/head",$a);
        $this->load->view("basic/menu");
        $this->load->view("admin/index/dashboard");
         $this->load->view("basic/footer");
    }
       
}
