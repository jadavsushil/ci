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
		$this->load->view('dashboard');
	}

	public function logout(){
		$this->session->sess_destroy();
		redirect('user/login');
	}
}
