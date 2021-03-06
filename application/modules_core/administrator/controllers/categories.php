<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class categories extends MX_Controller {
    /*
     * SamMarie Application V.1.0 Copyright 2014
     * Build Date : 17 Juli 2014
     * Founder & Programmer : Wisnu Groho Aji 
     * Website : http://wiqi.co
     */
      
    function __construct() {
        parent::__construct();
        $this->db_admin = $this->load->database("admin",TRUE);
        $this->db = $this->load->database("default", TRUE);
        $this->logged_in=$this->encrypt->decode($this->session->userdata("log_in"));
        $this->perm_user=$this->encrypt->decode($this->session->userdata("permission"));
    }
    
    function index(){
       if ($this->perm_user=="administrator" && $this->logged_in=="ikehikehkimochi"){
        $a['title'] = "SamMarie Application";
        $a['permission'] = $this->perm_user;
        $a['mweb'] = $this->models_admin->menu("web",$this->perm_user);
        $a['mblog'] = $this->models_admin->menu("blog",  $this->perm_user);
        $a['madmin'] = $this->models_admin->menu("admin",  $this->perm_user);
        $a['mproducts'] = $this->models_admin->menu("products",$this->perm_user);
        $a['link'] = $this->perm_user."/categories/add";
        $a['profile'] = $this->models_admin->profile_top($this->session->userdata("id_user"));
        $a['content'] = $this->models_admin->content('categories');
        
       
        $this->load->view("admin/head",$a);
        $this->load->view("admin/menu");
        $this->load->view("admin/categories");
        $this->load->view("admin/footer");
       }
       else{
            redirect("auth/auth");
        }
    }
    
    function add(){
       if ($this->perm_user=="administrator" && $this->logged_in=="ikehikehkimochi"){
        $a['title'] = "SamMarie Application - Tambah Kategori";
        $a['title2'] = "Tambah Kategori";
        $a['permission'] = $this->perm_user;
        $a['mweb'] = $this->models_admin->menu("web",$this->perm_user);
        $a['mblog'] = $this->models_admin->menu("blog",  $this->perm_user);
        $a['madmin'] = $this->models_admin->menu("admin",  $this->perm_user);
        $a['mproducts'] = $this->models_admin->menu("products",$this->perm_user);
        $a['profile'] = $this->models_admin->profile_top($this->session->userdata("id_user"));
        $a['action'] = $this->perm_user."/categories/save";
        $a['categories'] = $this->models_admin->categories("web",null);
        
        $this->load->view("admin/head",$a);
        $this->load->view("admin/menu");
        $this->load->view("admin/addcategories");
        $this->load->view("admin/footer");
       }
      else{
            redirect("auth/auth");
        }  
    }
    
    function update(){
       if ($this->perm_user=="administrator" && $this->logged_in=="ikehikehkimochi"){
          $uri="";
          if($this->uri->segment(4)===FALSE){
              $error="";
          }
          else{
              $uri=$this->uri->segment(4);
          }
        $a['title'] = "SamMarie Application - Tambah Kategori";
        $a['title2'] = "Edit Kategori";
        $a['permission'] = $this->perm_user;
        $a['mweb'] = $this->models_admin->menu("web",$this->perm_user);
        $a['mblog'] = $this->models_admin->menu("blog",  $this->perm_user);
        $a['madmin'] = $this->models_admin->menu("admin",  $this->perm_user);
        $a['mproducts'] = $this->models_admin->menu("products",$this->perm_user);
        $a['profile'] = $this->models_admin->profile_top($this->session->userdata("id_user"));
        $a['action'] = $this->perm_user."/categories/saveupdate";  
        $whre['tb_id_categories'] = $uri;
        $content = $this->db->get_where("wq_categories",$whre);
        foreach($content->result() as $b){
            $a['id'] = $b->tb_id_categories;
            $a['name'] = $b->tb_name_categories;
            $a['parent'] = $b->tb_sub_categories;
        }
        $a['categories'] = $this->models_admin->categories("web",$a['parent']);
        
        $this->load->view("admin/head",$a);
        $this->load->view("admin/menu");
        $this->load->view("admin/editcategories");
        $this->load->view("admin/footer");
       }
       else{
           redirect("auth/auth");
       }
    }
    
    function save(){
       if ($this->perm_user=="administrator" && $this->logged_in=="ikehikehkimochi"){
          $this->form_validation->set_rules('title','Title','trim|required');
           
           if ($this->form_validation->run()==FALSE){
               show_error("Validation Error Bro",500);
           }
           $insert['tb_name_categories'] = $this->input->post("title");
           $insert['tb_sub_categories'] = $this->input->post("kategori");
           $insert['tb_location_categories'] = "web";
           $insert['tb_status_categories'] = 1;
           
           $this->db->insert("wq_categories",$insert);
           redirect($this->perm_user."/categories");
       }
       else{
           redirect("auth/auth");
       }
    }
    
    function saveupdate(){
        if ($this->perm_user=="administrator" && $this->logged_in=="ikehikehkimochi"){
           $this->form_validation->set_rules('title','Title','trim|required');
           
           if ($this->form_validation->run()==FALSE){
               show_error("Validation Error Bro",500);
           }
           $insert['tb_name_categories'] = $this->input->post("title");
           $insert['tb_sub_categories'] = $this->input->post("kategori");
           $insert['tb_location_categories'] = "web";
           $insert['tb_status_categories'] = 1;
           $where = $this->input->post("id");
           
           $this->db->where("tb_id_categories",$where);
           $this->db->update("wq_categories",$insert);
            $this->session->set_flashdata("result_action",'<div class="alert margin"><button type="button" class="close" data-dismiss="alert">X</button>Categories Berhasil Di edit</div>');
           redirect($this->perm_user."/categories");
       }
       else{
           redirect("auth/auth");
       }
    }
    
    function delete(){
      if ($this->perm_user=="administrator" && $this->logged_in=="ikehikehkimochi"){
           $uri="";
           if ($this->uri->segment(4)===FALSE){
               $uri = "";
           }
           else{
               $uri=$this->uri->segment(4);
           }
           
           $where['tb_id_categories'] = $uri;
           $this->db->delete("wq_categories",$where);
           $this->session->set_flashdata("result_action",'<div class="alert margin"><button type="button" class="close" data-dismiss="alert">X</button>Categories Berhasil Di Hapus</div>');
           redirect($this->perm_user."/categories");
      }
      else{
          redirect("auth/auth");
      }
    }
       
}
