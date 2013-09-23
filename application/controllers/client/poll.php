<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Poll extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('poll_model');
	}
	public function question($poll_id)
	{
		$data = array();
		$data['poll'] = $this->poll_model->get_polls($poll_id);
		$data['poll']['type'] = ($data['poll']['multi_select'] ? 'checkbox' : 'radio');;
		$data['answers'] = $this->poll_model->get_answers(0,$poll_id);
		$data['page_title'] = $data['poll']['question'];
		$this->load->view('common/header',$data);
		$this->load->view('clients/poll',$data);
		$this->load->view('common/footer',$data);
	}
	public function ajax_load_result(){
		if($answers = $this->poll_model->can_view_poll_result(@$this->input->post('poll_id'))) {
			$data = array(
				'poll' => $this->poll_model->get_polls($this->input->post('poll_id')),
				'answers' => $answers,
			);
			$this->load->view('clients/poll_result',$data);
		} else {
			echo '<li class="list-group-item">Result is Private!</li>';
		}
	}
	public function ajax_poll_vote(){
		if(count($this->input->post('client_poll_vote_answer'))){
			if($this->poll_model->client_poll($this->input->post('client_poll_vote_poll_id'))){
				echo '1';
			} else {
				echo '0';
			}
		} else {
			echo '0';
		}
	}
	public function ajax_load_poll()
	{
		$poll_id = @$this->input->post('poll_id');
		$data = array();
		$data['poll'] = $this->poll_model->get_polls($poll_id);
		$data['poll']['type'] = ($data['poll']['multi_select'] ? 'checkbox' : 'radio');;
		$data['answers'] = $this->poll_model->get_answers(0,$poll_id);
		$this->load->view('clients/vote',$data);
	}
}
