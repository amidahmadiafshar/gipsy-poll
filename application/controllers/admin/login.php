<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('admin_model');
	}
	public function index()
	{
		if($this->admin_model->admin_logged()){
			header('Location:'.base_url('index.php/admin/index').'');
		}
		$data = array();
		$data['page_title'] = 'Admin Login';
		$this->load->view('common/header',$data);
		$this->load->view('admin/login',$data);
		$this->load->view('common/footer',$data);
	}
	public function ajax_login()
	{
		if($this->input->post('admin_login_username')){
			if($this->input->post('admin_login_password')){
				if($id = $this->admin_model->admin_can_login()){
					$this->session->set_userdata('admin_id',md5($id));
					echo '<span class="alert alert-success">You are logged in successfully!</span><script>setTimeout(function(){location.reload();},1000);</script>';
				} else {
					echo '<span class="alert alert-danger">Username & Password is not match</span>';
				}
			} else {
				echo '<span class="alert alert-danger">Please enter your password!</span>';
			}
		} else {
			echo '<span class="alert alert-danger">Please enter your username!</span>';
		}
	}
	public function ajax_logout()
	{
		$this->session->set_userdata('admin_id','');
		echo '<script>alert("You are logged out successfully!");location.reload();</script>';
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */