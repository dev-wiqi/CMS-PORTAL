<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class news extends MX_Controller {
    /*
     * SumberNews Portal Application V.1.0 Copyright 2014
     * Build Date : 17 Juli 2014
     * Founder & Programmer : Wisnu Groho Aji 
     * Website : http://wiqi.co
     */
    
    function __construct() {
        parent::__construct();
        $this->db_admin = $this->load->database("admin",TRUE);
        $this->db = $this->load->database("default", TRUE);
        $this->perm_user=$this->encrypt->decode($this->session->userdata("permission"));
        }
    
    function index(){
        $this->models_auth->is_admin();
        $a['title'] = "News";
        $a['permission'] = $this->perm_user;
        $a['mweb'] = $this->models_admin->menu("web",$this->perm_user);
        $a['mblog'] = $this->models_admin->menu("blog",  $this->perm_user);
        $a['madmin'] = $this->models_admin->menu("admin",  $this->perm_user);
        $a['mproducts'] = $this->models_admin->menu("products",$this->perm_user);
        $a['mnews'] = $this->models_admin->menu("news",$this->perm_user);
        $a['link'] = $this->perm_user."/products/add";
        $a['profile'] = $this->models_admin->profile_top($this->session->userdata("id_user"));
        $a['content'] = $this->models_admin->content('news');
        
        $this->load->view("basic/head",$a);
        $this->load->view("basic/menu");
        $this->load->view("index/news");
        $this->load->view("basic/footer");
        }
      
    function add(){
        $this->models_auth->is_admin();
        $a['title'] = "SumberNews - Tambah Berita";
        $a['title2'] = "Tambah Berita";
        $a['permission'] = $this->perm_user;
        $a['mweb'] = $this->models_admin->menu("web",$this->perm_user);
        $a['mblog'] = $this->models_admin->menu("blog",  $this->perm_user);
        $a['madmin'] = $this->models_admin->menu("admin",  $this->perm_user);
        $a['mproducts'] = $this->models_admin->menu("products",$this->perm_user);
        $a['profile'] = $this->models_admin->profile_top($this->session->userdata("id_user"));
        $a['action'] = $this->perm_user."/news/save";
        $a['link'] = $this->perm_user."/news/add";
        $a['categories'] = $this->models_admin->categories('news',null);
        
        $this->load->view("basic/head",$a);
        $this->load->view("basic/menu");
        $this->load->view("add/addnews");
        $this->load->view("basic/footer");
    }
    
    function update(){
        $this->models_auth->is_admin();
        $uri="";
          if($this->uri->segment(4)===FALSE){
              show_error("Validation Error Bro",500);
          }
          else{
              $uri=$this->uri->segment(4);
          }
        $a['title'] = "SumberNews - Edit Berita";
        $a['title2'] = "Edit Berita";
        $a['permission'] = $this->perm_user;
        $a['mweb'] = $this->models_admin->menu("web",$this->perm_user);
        $a['mblog'] = $this->models_admin->menu("blog",  $this->perm_user);
        $a['madmin'] = $this->models_admin->menu("admin",  $this->perm_user);
        $a['mproducts'] = $this->models_admin->menu("products",$this->perm_user);
        $a['profile'] = $this->models_admin->profile_top($this->session->userdata("id_user"));
        $a['action'] = $this->perm_user."/news/save";
        $a['link'] = $this->perm_user."/news/add";
        $a['categories'] = $this->models_admin->categories('news',null);
        $whre['tb_id_news'] = $uri;
        $content = $this->db_admin->get_where("wq_news",$whre);
        foreach($content->result() as $b){
            $a['id'] = $b->tb_id_news;
            $a['name'] = $b->tb_name_news;
            $a['link'] = $b->tb_link_news;
            $a['icon'] = $b->tb_icon_news;
        }
        
        $this->load->view("basic/head",$a);
        $this->load->view("basic/menu");
        $this->load->view("edit/editnews");
        $this->load->view("basic/footer");
    }
    
    function save(){
        $this->models_auth->is_admin();
        
    }
    
    function saveupdate(){
        $this->models_auth->is_admin();
        
    }
}