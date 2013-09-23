<?php 

class Poll_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
		$this->load->database();
    }
	function get_polls($id=0){
		if($id){
			$query = $this->db->get_where('polls',array('poll_id'=>$id));
			$result = $query->row_array();
			return $result;
		} else {
			$query = $this->db->get('polls');
			$result = $query->result_array();
			return $result;
		}
		
	}
	function get_answers($id=0,$poll_id=0){
		if($id){
			$query = $this->db->get_where('answers',array('answer_id'=>$id));
			$result = $query->row_array();
			return $result;
		} else if($poll_id) {
			$query = $this->db->get_where('answers',array('poll_id'=>$poll_id));
			$result = $query->result_array();
			return $result;
		} else {
			$query = $this->db->get('answers');
			$result = $query->result_array();
			return $result;
		}
		
	}
	function get_votes($poll_id=0, $ipaddress=0){
		if($poll_id) {
			if($ipaddress) {
				$query = $this->db->get_where('votes',array('poll_id'=>$poll_id, 'ip_address'=>$ipaddress));
				$result = $query->result_array();
				return $result;
			} else {
				$query = $this->db->get_where('votes',array('poll_id'=>$poll_id));
				$result = $query->result_array();
				return $result;
			}
		} else {
			$query = $this->db->get('votes');
			$result = $query->result_array();
			return $result;
		}
		
	}
	function admin_add_poll(){
		$data = array();
		$data['question'] = $this->input->post('admin_add_poll_question');
		$data['multi_select'] = $this->input->post('admin_add_poll_multi_select');
		$data['view_result'] = $this->input->post('admin_add_poll_view_result');
		$answers = $this->input->post('admin_add_poll_answer');
		$this->db->insert('polls',$data);
		$poll_id = $this->db->insert_id();
		foreach($answers as $a){
			$data2 = array();
			$data2['answer'] = $a;
			$data2['poll_id'] = $poll_id;
			$this->db->insert('answers',$data2);
		}
	}
	function admin_del_poll($poll_id){
		$this->db->where('poll_id',$poll_id);
		$this->db->delete('polls'); 
		$this->db->where('poll_id',$poll_id);
		$this->db->delete('answers'); 
		$this->db->where('poll_id',$poll_id);
		$this->db->delete('votes'); 
	}
	function admin_edit_poll($poll_id){
		$data = array();
		$data['question'] = $this->input->post('admin_edit_poll_question'.$poll_id);
		$data['multi_select'] = $this->input->post('admin_edit_poll_multi_select'.$poll_id);
		$data['view_result'] = $this->input->post('admin_edit_poll_view_result'.$poll_id);
		$answers = $this->input->post('admin_edit_poll_answer'.$poll_id);
		$this->db->where('poll_id',$poll_id);
		$this->db->update('polls',$data);
		foreach($answers as $key=>$a){
			$data2['answer'] = $a;
			$answer_id = $key;
			$this->db->where('answer_id',$answer_id);
			$this->db->update('answers',$data2);
		}
	}
	function poll_voted($poll_id){
		$ipaddress = $_SERVER['REMOTE_ADDR'];
		$votes = $this->get_votes($poll_id, $ipaddress);
		if(count($votes)){
			return true;
		} else {
			return false;
		}
	}
	function can_view_poll_result($poll_id){
		$poll = $this->get_polls($poll_id);
		if($poll['view_result'] == 1 || ($poll['view_result'] == 2 && $this->poll_voted($poll_id))){
			$answers = $this->get_answers(0,$poll_id);
			return $answers;
		} else {
			return false;
		}
	}
	function client_poll($poll_id){
		if(!$this->poll_voted($poll_id)){
			$votes = $this->input->post('client_poll_vote_answer');
			$data = array();
			$data['ip_address'] = $_SERVER['REMOTE_ADDR'];
			$data['vote_note'] = $this->input->post('client_poll_vote_note');
			$data['poll_id'] = $poll_id;
			$data['time'] = time();
			foreach($votes as $v){
				$data['answer_id'] = $v;
				$this->db->insert('votes',$data);
				$this->db->query("UPDATE answers SET votes=votes+1 WHERE answer_id=$v");
				$this->db->query("UPDATE polls SET votes=votes+1 WHERE poll_id=$poll_id");
			}
			return true;
		}
	}
}