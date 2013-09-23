<?php 

class Admin_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
		$this->load->database();
    }
	function admin_can_login(){
		$username = $this->input->post('admin_login_username');
		$password = $this->input->post('admin_login_password');
		$password = md5($password);
		$query = $this->db->get_where('admin', array('username' => $username,'password'=>$password));
		$result = $query->result_array();
		$count = count($result);
		$query2 = $this->db->get_where('admin', array('email' => $username,'password'=>$password));
		$result2 = $query2->result_array();
		$count2 = count($result2);
		if ($count == 1) {
			return $result[0]['admin_id'];
		} elseif($count2 == 1) {
			return $result2[0]['admin_id'];
		} else {
			return 0;
		}
	}
	function admin_logged(){
		$return = false;
		$sess = @$this->session->userdata('admin_id');
		$query = $this->db->get('admin');
		$result = $query->result_array();
		foreach($result as $r){
			if($sess == md5($r['admin_id'])){
				$return = true;
			}
		}
		return $return;
	}
	function logged_admin(){
		$return = false;
		$sess = @$this->session->userdata('admin_id');
		$query = $this->db->get('admin');
		$result = $query->result_array();
		foreach($result as $r){
			if($sess == md5($r['admin_id'])){
				$return = $r;
			}
		}
		return $return;
	}
	function admin_can_change_pass(){
		$password = $this->input->post('admin_change_pass_current_pass');
		$password = md5($password);
		$admin = $this->logged_admin();
		if ($password == $admin['password']) {
			return true;
		} else {
			return false;
		}
	}
	function admin_change_pass(){
		$password = $this->input->post('admin_change_pass_new_pass');
		$password = md5($password);
		$admin = $this->logged_admin();
		$this->db->where('admin_id',$admin['admin_id']);
		$this->db->update('admin', array('password'=>$password)); 
	}
	function get_admins(){
		$query = $this->db->get('admin');
		$result = $query->result_array();
		return $result;
	}
	function admin_add_admin(){
		$data = array();
		$data['fname'] = $this->input->post('admin_add_admin_fname');
		$data['lname'] = $this->input->post('admin_add_admin_lname');
		$data['username'] = $this->input->post('admin_add_admin_username');
		$data['email'] = $this->input->post('admin_add_admin_email');
		$data['pro_admin'] = $this->input->post('admin_add_admin_pro_admin');
		$password = rand(10000,99999);
		$data['password'] = md5($password);
		$this->db->insert('admin',$data);
		mail($data['email'],'password',$password);
	}
	function admin_del_admin($admin_id){
		$this->db->where('admin_id',$admin_id);
		$this->db->delete('admin'); 
	}
	function admin_edit_admin($admin_id){
		$data = array();
		$data['fname'] = $this->input->post('admin_edit_admin_fname');
		$data['lname'] = $this->input->post('admin_edit_admin_lname');
		$data['pro_admin'] = $this->input->post('admin_edit_admin_pro_admin');
		$this->db->where('admin_id',$admin_id);
		$this->db->update('admin',$data); 
	}
	function is_super_admin(){
		if($this->logged_admin()){
			$admin = $this->logged_admin();
			return $admin['super_admin'];
		} else {
			return false;
		}
	}
	function is_pro_admin(){
		if($this->logged_admin()){
			$admin = $this->logged_admin();
			return $admin['pro_admin'];
		} else {
			return false;
		}
	}
}