<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 error_reporting(0);
class User extends CI_Controller {
 
	function __construct(){
		parent::__construct();
		$this->load->model('users_model');
		$this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->library('email');
 
        //get all users
        $this->data['users'] = $this->users_model->getAllUsers();

        if($_SESSION['role']=='user'){
            redirect('/dashboard');
        }elseif($_SESSION['role']=='admin'){
            redirect('/admin/dashboard');
        }
	}
 
	public function index(){
		$this->load->view('login', $this->data);
	}
    
    public function login(){
        $this->form_validation->set_rules('email', 'Email', 'valid_email|required');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[7]|max_length[30]');
        if ($this->form_validation->run() == FALSE) { 
            $this->load->view('login', $this->data);
        }
       else{
            $status = $this->users_model->check_auth();
            if($status=='404'){
                $this->session->set_flashdata('message', 'Please enter correct email and password!');
                redirect('user/login');
            }elseif($status['role']=='admin'){
                redirect('/admin/dashboard');
            }else{
                redirect('/dashboard');
            }
       }
    }

	public function register(){
        $config['protocol']    = 'smtp';
        $config['smtp_host']    = 'ssl://smtp.gmail.com';
        $config['smtp_port']    = '465';
        $config['smtp_timeout'] = '7';
        $config['smtp_user']    = 'arush929292@gmail.com';
        $config['smtp_pass']    = 'Dev@12345';
        $config['charset']    = 'utf-8';
        $config['newline']    = "\r\n";
        $config['mailtype'] = 'html'; 
        $config['validation'] = TRUE; 

        $this->email->initialize($config);

		$this->form_validation->set_rules('email', 'Email', 'valid_email|required');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[7]|max_length[30]');
        $this->form_validation->set_rules('password_confirm', 'Confirm Password', 'required|matches[password]');
 
        if ($this->form_validation->run() == FALSE) { 
         	$this->load->view('register', $this->data);
		}
		else{
			//get user inputs
			$email = $this->input->post('email');
			$password = $this->input->post('password');
 
			//generate simple random code
			$set = '123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$code = substr(str_shuffle($set), 0, 12);
 
			//insert user to users table and get id
			$user['email'] = $email;
			$user['password'] = md5($password);
			$user['code'] = $code;
			$user['active'] = false;
			$id = $this->users_model->insert($user);
 
			$message = 	"
						<html>
						<head>
							<title>Verification Code</title>
						</head>
						<body>
							<h2>Thank you for Registering.</h2>
							<p>Your Account:</p>
							<p>Email: ".$email."</p>
							<p>Password: ".$password."</p>
							<p>Please click the link below to activate your account.</p>
							<h4><a href='".base_url()."user/activate/".$id."/".$code."'>Activate My Account</a></h4>
						</body>
						</html>
						";
            
		    $this->email->set_newline("\r\n");
		    $this->email->from($config['smtp_user'],'Ci Test');
		    $this->email->to($email);
		    $this->email->subject('Signup Verification Email');
		    $this->email->message($message);
          
		    //sending email
		    if($this->email->send()){
		    	$this->session->set_flashdata('message','Activation code sent to email');
                
		    }
		    else{
		    	$this->session->set_flashdata('message', $this->email->print_debugger());
 
		    }
 
        	redirect('register');
		}
 
	}
 
	public function activate(){
		$id =  $this->uri->segment(3);
		$code = $this->uri->segment(4);

		$user = $this->users_model->getUser($id);
 
		if($user['code'] == $code){
			//update user active status
			$data['active'] = true;
			$query = $this->users_model->activate($data, $id);
 
			if($query){
				$this->session->set_flashdata('message', 'User activated successfully');
			}
			else{
				$this->session->set_flashdata('message', 'Something went wrong in activating account');
			}
		}
		else{
			$this->session->set_flashdata('message', 'Cannot activate account. Code didnt match');
		}
 
		redirect('login');
 
	}
 
}