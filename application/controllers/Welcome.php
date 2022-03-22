<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {
	

	function __construct(){
		parent::__construct();
		$this->load->model('users_model');
		$this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->library('email');
 
        //get all users
        $this->data['users'] = $this->users_model->getAllUsers();

        if(empty($_SESSION['role'])){
            redirect('user/login');
        }
	}

	public function index()
	{
		$data=array();
		$data['title']="User Dashboard";
		$data['user_details'] = $this->users_model->showUserInformation();
		$data['show_product'] = $this->users_model->showAllActiveProducts();
		$data['show_userProduct'] = $this->users_model->showUserProduct();
		
		$this->load->view('dashboard',$data);
	}

	public function logout(){
		$this->session->sess_destroy();
		redirect('user/login');
	}

	public function user_addProduct(){
		return $this->users_model->add_userProducts($this->input->post('id'),$this->input->post('qty'),$this->input->post('price'));
	}
}
