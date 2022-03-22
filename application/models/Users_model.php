<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getAllUsers(){
        $query= $this->db->get('users');
        return $query->result();
    }

    public function insert($user){
        $this->db->insert('users',$user);
        return $this->db->insert_id();
    }

    public function getUser($id){
        $query = $this->db->get_where('users',array('id'=>$id));
        return $query->row_array();
    }

    public function activate($data,$id){
        $this->db->where('users.id',$id);
        return $this->db->update('users',$data);
    }

    public function check_auth(){
        
        $email = $this->input->post('email');
        $password = md5($this->input->post('password'));
        $check_record = $this->db->select('*')->from('users')->where('email',$email)->get()->row();
        
        if(empty($check_record)){
            return "404";
        }elseif($check_record->password!=$password){
            return "404";
        }elseif($check_record->password==$password){
            $data = array(
            'role' => $check_record->role,
            'user_id' => $check_record->id
            );
            $this->session->set_userdata($data);
            return $data;
        }
    }
    
    public function showUserInformation(){
        return $this->db->select('*')
                        ->from('users')
                        ->where('id',$_SESSION['user_id'])
                        ->get()
                        ->row();
    }

    public function showAllActiveProducts(){
        return $this->db->select('*')
                        ->from('products')
                        ->where('status','1')
                        ->get()
                        ->result();
    }

    public function add_userProducts($id,$qty,$price){
        $data=array();
        $data['user_id']=$_SESSION['user_id'];
        $data['product_id']=$id;
        $data['qty']=$qty;
        $data['price']=$price;
        $this->db->insert('user_products',$data);
        return $this->db->insert_id();
    }

    public function showUserProduct(){
        return $this->db->select('UP.*,PRO.title,PRO.description,PRO.image,sum(UP.qty) TOTALQTY')
                        ->from('user_products UP')
                        ->join('products PRO','PRO.id=UP.product_id')
                        ->where('UP.user_id',$_SESSION['user_id'])
                        ->group_by('UP.product_id')
                        ->group_by('UP.price')
                        ->get()
                        ->result();
    }
}
