<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Index extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('admin_model');
		$this->load->model('poll_model');
	}
	public function index()
	{	
		if(!$this->admin_model->admin_logged()){
			header('Location:'.base_url('index.php/admin/login').'');
		}
		$data = array();
		$data['admins'] = $this->admin_model->get_admins();
		$data['logged_admin'] = $this->admin_model->logged_admin();
		$data['polls'] = $this->poll_model->get_polls();
		$data['votes'] = $this->poll_model->get_votes();
		$data['page_title'] = 'Admin Panel';
		$this->load->view('common/header',$data);
		$this->load->view('admin/index',$data);
		$this->load->view('common/footer',$data);
	}
	public function ajax_change_pass()
	{
		if($this->input->post('admin_change_pass_current_pass')){
			if($this->input->post('admin_change_pass_new_pass')){
				if($this->input->post('admin_change_pass_re_pass')){
					if($this->input->post('admin_change_pass_re_pass') == $this->input->post('admin_change_pass_new_pass')){
						if($this->admin_model->admin_can_change_pass()){
							$this->admin_model->admin_change_pass();
							echo '<span class="alert alert-success">Your Password has successfully!</span><script>$("#admin_change_pass")[0].reset();</script>';
						} else {
							echo '<span class="alert alert-danger">Wrong Current Password!</span>';
						}
					} else {
						echo '<span class="alert alert-danger">New Password & Repeat Password Does Not Match!</span>';
					}
				} else {
					echo '<span class="alert alert-danger">Please repeat your new password!</span>';
				}
			} else {
				echo '<span class="alert alert-danger">Please enter your new password!</span>';
			}
		} else {
			echo '<span class="alert alert-danger">Please enter your current password!</span>';
		}
	}
	public function ajax_add_admin()
	{
		if($this->input->post('admin_add_admin_username')){
			if($this->input->post('admin_add_admin_email')){
				if($this->admin_model->admin_logged() && $this->admin_model->is_super_admin()){
					$this->admin_model->admin_add_admin();
					echo 'Admin Added Successfully!';
				} else {
					echo 'Please Login...';
				}
			} else {
				echo 'Please Enter an Email!';
			}
		} else {
			echo 'Please Enter an Username!';
		}
	}
	public function ajax_add_poll()
	{
		if($this->input->post('admin_add_poll_question')){
			if($this->input->post('admin_add_poll_answer')){
				if($this->admin_model->admin_logged() && $this->admin_model->is_pro_admin()){
					$this->poll_model->admin_add_poll();
					echo 'Poll Added Successfully!';
				} else {
					echo 'Please Login...';
				}
			} else {
				echo 'Please enter at least one answer!';
			}
		} else {
			echo 'Please Enter Question!';
		}
	}
	public function ajax_del_admin()
	{
		if($this->input->post('admin_del_admin_id')){
			if($this->admin_model->admin_logged() && $this->admin_model->is_super_admin()){
				$this->admin_model->admin_del_admin($this->input->post('admin_del_admin_id'));
				echo 'Admin Deleted Successfully!';
			} else {
				echo 'Please Login...';
			}
		} else {
			echo 'Error';
		}
	}
	public function ajax_del_poll()
	{
		if($this->input->post('admin_del_poll')){
			if($this->admin_model->admin_logged() && $this->admin_model->is_pro_admin()){
				$this->poll_model->admin_del_poll($this->input->post('admin_del_poll_id'));
				echo 'Poll Deleted Successfully!';
			} else {
				echo 'Please Login...';
			}
		} else {
			echo 'Error';
		}
	}
	public function ajax_load_admins(){
		$data['admins'] = $this->admin_model->get_admins();
		$this->load->view('admin/admins',$data);
	}
	public function ajax_load_polls(){
		$data['polls'] = $this->poll_model->get_polls();
		$this->load->view('admin/polls',$data);
	}
	public function ajax_edit_admin()
	{
		if($this->input->post('admin_edit_admin_id')){
			if($this->admin_model->admin_logged() && $this->admin_model->is_super_admin()){
				$this->admin_model->admin_edit_admin($this->input->post('admin_edit_admin_id'));
				echo 'Admin Edited Successfully!';
			} else {
				echo 'Please Login...';
			}
		} else {
			echo 'Error';
		}
	}
	public function ajax_edit_poll()
	{
		if($this->input->post('admin_edit_poll_id')){
			if($this->admin_model->admin_logged() && $this->admin_model->is_pro_admin()){
				$this->poll_model->admin_edit_poll($this->input->post('admin_edit_poll_id'));
				echo 'Poll Edited Successfully!';
			} else {
				echo 'Please Login...';
			}
		} else {
			echo 'Error';
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */