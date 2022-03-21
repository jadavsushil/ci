<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		$this->load->model('users_model');
		$this->load->model('admin_model');
		$this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->library('session');
		$this->load->library('upload');
        //get all users
        $this->data['users'] = $this->users_model->getAllUsers();

        if(empty($_SESSION['role'])){
            redirect('user/login');
        }
	}

	public function index()
	{
		$data=array();
		$data['title']='Dashboard';
		$data['show_product_records'] = $this->admin_model->showAllProducts();
		$data['show_active_users'] = $this->admin_model->show_active_users();
		$data['show_active_products'] = $this->admin_model->show_active_products();
		
		$this->load->view('admin/dashboard',$data);
	}

	public function logout(){
		$this->session->sess_destroy();
		redirect('user/login');
	}

	public function add_product(){
		$data=array();
		$data['title']=$this->input->post('title');
		$data['description']=$this->input->post('description');
		$data['status']='1';

		if(!empty($_FILES['product_image']['name'])){
			
			$config['upload_path'] = 'uploads/';
			$config['allowed_types'] = 'jpg|jpeg|png|gif';
			$config['file_name'] = $_FILES['product_image']['name'];
			
			//Load upload library and initialize here configuration
			$this->load->library('upload',$config);
			$this->upload->initialize($config);
			
			if($this->upload->do_upload('product_image')){
				$uploadData = $this->upload->data();
				$data['image'] = $uploadData['file_name'];
			}else{
				$data['image'] = '';
			}
		}else{
			$data['image'] = '';
		}


		if($this->admin_model->store_product($data)){
			$this->session->set_flashdata('message','Product Inserted Successfully!');
			redirect('admin/dashboard');			
		}

		redirect('admin/dashboard');
	}
}
