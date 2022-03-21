<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function store_product($data){
        $this->db->insert('products',$data);
        return $this->db->insert_id();
    }
  
    public function showAllProducts(){
        return $this->db->select('*')
                        ->from('products')
                        ->get()
                        ->result();
    }

    public function show_active_users(){
        return $this->db->select('*')
                        ->from('users')
                        ->where('active','1')
                        ->get()
                        ->result();
    }

    public function show_active_products(){
        return $this->db->select('*')
                        ->from('products')
                        ->where('status','1')
                        ->get()
                        ->result();
    }
}
