<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax extends CI_Controller {
	
	public function __construct() {
		
		parent::__construct();
		if (!$_SESSION['ci_session']) {
			
			exit;
			
		}
		$this->load->model('Ajax_model');
		
	}
	
	public function taskDelete() {
		
		echo $this->Ajax_model->taskDelete($this->input->post('tid'));
		
	}

	public function taskTitle() {
		
		echo $this->Ajax_model->taskTitle($this->input->post('pk'), $this->input->post('value'));
		
	}
	
	public function taskStatus() {
		
		echo $this->Ajax_model->taskStatus($this->input->post('pk'), $this->input->post('value'));
		
	}
	
	public function taskStatuses() {
		
		$statuses = $this->Ajax_model->taskStatuses();
		foreach ($statuses AS $status) {
			
			$array[$status['tsid']] = $status['name'];
			
		}
		
		echo json_encode($array);
		
	}
	
	public function taskDue() {
		
		echo $this->Ajax_model->taskDue($this->input->post('pk'), $this->input->post('value'));
		
	}
	
	public function taskContent() {
		
		echo $this->Ajax_model->taskContent($this->input->post('tid'), $this->input->post('value'));
		
	}
	
	public function taskAssign() {
		
		echo $this->Ajax_model->taskAssign($this->input->post('pk'), $this->input->post('value'));
		
	}
	
	public function notificationRead() {
		
		echo $this->Ajax_model->notificationRead($this->input->post('nid'));
		
	}
	
}
