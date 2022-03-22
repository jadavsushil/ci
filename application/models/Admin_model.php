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

    public function countActVerUserProduct(){
        return $this->db->select('*')
                        ->from('user_products UPR')
                        ->join('products PRO','PRO.id=UPR.product_id')
                        ->join('users USE','USE.id=UPR.user_id')
                        ->where('UPR.status','1')
                        ->where('PRO.status','1')
                        ->where('USE.active','1')->where('USE.status','1')->where('USE.role','user')
                        ->group_by('UPR.user_id')
                        ->get()
                        ->result();
    }

    public function countActProDontUser(){
        $total_user_pro = $this->db->select('UPRO.product_id')
                                    ->from('user_products UPRO')
                                    ->join('products PRO','PRO.id=UPRO.product_id')
                                    ->group_by('UPRO.product_id')
                                    ->get()
                                    ->result();
                                    
        $data=array();

        foreach($total_user_pro as $result){
            $data[]=$result->product_id;
        }

        return $this->db->select('*')
                        ->from('products')
                        ->where('status','1')
                        ->where_not_in('id',$data)
                        ->get()
                        ->result();
    }

    public function CountQTYActiveProductsUser(){
        return $this->db->select('sum(UPRO.qty) TotalProduct')
                                    ->from('user_products UPRO')
                                    ->join('products PRO','PRO.id=UPRO.product_id')
                                    ->where('PRO.status','1')
                                    ->get()
                                    ->row();
    }

    public function CountPriceActiveProductsUser(){
        $total =  $this->db->select('UPRO.*,sum(UPRO.qty) totalqty, sum(UPRO.qty*UPRO.price) totalprice')
                        ->from('user_products UPRO')
                        ->join('products PRO','PRO.id=UPRO.product_id')
                        ->where('PRO.status','1')
                        ->group_by('UPRO.product_id')
                        ->get()
                        ->result();
        
        $data='0';
        foreach($total as $result){
            $data += ($result->totalprice);
        }
        return $data;
    }

    public function getAllUsers(){
        return $this->db->select('*')
                        ->from('users')
                        ->where('role','user')
                        ->get()
                        ->result();
    }

    public function getSumProPrice($user_id){
      
        $get_qty= $this->db->select('*')
                        ->from('user_products UPRO')
                        ->join('products PRO','PRO.id=UPRO.product_id')
                        ->where('PRO.status','1')
                        ->where('UPRO.user_id',$user_id)
                        ->get()
                        ->result();
        $data='0';
        foreach($get_qty as $result){
            $data += ($result->price);
        }
        return $data;       
    }

    public function updateProductStatus($pro_id){
        $check_pro = $this->db->select('id,status')
                              ->from('products')
                              ->where('id',$pro_id)
                              ->get()
                              ->row();
        
        if($check_pro->status=='1'){
            $data['status']='2';
            $this->db->where('products.id',$pro_id);
            $this->db->update('products',$data);
            return '2';
        }else{
            $data['status']='1';
            $this->db->where('products.id',$pro_id);
            $this->db->update('products',$data);
            return '1';
        }
    }
    
}
