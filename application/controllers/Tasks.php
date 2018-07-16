<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tasks extends CI_Controller {
	
	public function __construct() {
		
		parent::__construct();
		if (!$_SESSION['ci_session']) {
			
			redirect('welcome/login');
			
		}
		$this->lang->load(array('tasks','misc'), 'english');
		$this->load->model('Tasks_model');
		$this->load->helper('form');
		
		$this->headerData['session'] = $this->session->userdata('ci_session');
		$this->headerData['user'] = $this->User_model->getEmployee($this->headerData['session']->eid);
		$this->headerData['notifications'] = $this->User_model->getNotifications($this->headerData['session']->eid);
		
	}

	public function index() {

		$data['statuses'] = array('all' => $this->lang->line('all_statuses')) + $this->Tasks_model->getStatuses(1);
		$data['statuses_drop'] = $this->Tasks_model->getStatuses(1);
		$employees = $this->User_model->getEmployees();
		foreach ($employees AS $eid => $employee) {
			
			$data['employees'][$employee['eid']] = $employee['name_first']." ".$employee['name_last'];
			
		}
		
		$data['employees'] = array('all' => $this->lang->line('all_employees')) + $data['employees'];
		
		$data['tasks'] = $this->Tasks_model->getTasks();
		
		if ($this->input->post()) {
			
			$data['tasks'] = $this->Tasks_model->getTasks($this->input->post('employee'), $this->input->post('status'));
			
		}
		
		$this->load->view('header', $this->headerData);
		$this->load->view('tasks', $data);
		$this->load->view('footer');
		
	}
	
	public function view($tid) {
		
		$data['employees'] = $this->User_model->getEmployees();
		$data['task'] = $this->Tasks_model->getTask($tid);
		
		$this->load->view('header', $this->headerData);
		$this->load->view('tasks_view', $data);
		$this->load->view('footer');
		
	}
	
	public function add() {
		
		$this->load->library('form_validation');
		$data['statuses'] = $this->Tasks_model->getStatuses(1);
		$employees = $this->User_model->getEmployees();
		foreach ($employees AS $eid => $employee) {
			
			$data['employees'][$employee['eid']] = $employee['name_first']." ".$employee['name_last'];
			
		}
		
		$this->form_validation->set_rules('title', 'Title', 'required');
		
		if ($this->form_validation->run()) {
			
			$this->Tasks_model->addTask($this->input->post());
			
			$data['result']['type'] = "success";
			$data['result']['message'] = $this->lang->line('form_submit_add_success');
			
		} else {
			
			$data['result']['type'] = "error";
			$data['result']['message'] = $this->lang->line('form_submit_add_error');
			
		}
		
		$this->load->view('header', $this->headerData);
		$this->load->view('tasks_add', $data);
		$this->load->view('footer');
		
	}
	
}
