<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {
	
	public function __construct() {
		
		parent::__construct();
		$this->lang->load(array('welcome','misc'), 'english');
		
		$this->headerData['session'] = $this->session->userdata('ci_session');
		$this->headerData['user'] = $this->User_model->getEmployee($this->headerData['session']->eid);
		$this->headerData['notifications'] = $this->User_model->getNotifications($this->headerData['session']->eid);
		
	}

	public function index() {
		
		if (!$_SESSION['ci_session']) {
			
			redirect('welcome/login');
			
		}
		
		$this->load->model('Timeclock_model');
		$this->load->model('Math_model');
		$data['last_punch'] = $this->Timeclock_model->getPunch($this->headerData['user']->last_punch);
		$data['punch_difference'] = (time() - $this->headerData['user']->timestamp) * 1000;
		$data['latest_punches'] = $this->Timeclock_model->getPunches($this->headerData['user']->eid, 5);
		$data['latest_hours'] = $this->Math_model->countTime(date('Y-m-d', strtotime('-4 days')), date('Y-m-d'), $this->headerData['user']->eid);
		
		$data['latest_hours_total'] = 0;
		foreach ($data['latest_hours'] AS $hour) {
			
			$data['latest_hours_total'] = $data['latest_hours_total'] + $hour['total'];
			
		}
		
		
		$this->load->view('header', $this->headerData);
		$this->load->view('welcome', $data);
		$this->load->view('footer');
		
	}
	
	public function login() {
		
		$this->load->helper('form');
		
		$data = array();
		if ($this->input->post()) {
			
			$this->load->library('form_validation');
			$this->form_validation->set_rules('username', 'lang:username', 'required|trim');
			$this->form_validation->set_rules('password', 'lang:password', 'required');
			
			if ($this->form_validation->run() == TRUE) {
			
				$this->load->model('Welcome_model');
				$userinfo = $this->Welcome_model->login($this->input->post('username'), $this->input->post('password'));
				if ($userinfo) {
					
					$data['result']['color'] = "#30ed17";
					$data['result']['text'] = $this->lang->line('login_success');
					
					redirect('welcome');
					
				} else {
					
					$data['result']['color'] = "#FF0000";
					$data['result']['text'] = $this->lang->line('login_invalid');
					
				}
				
			} else {
				
					$data['result']['color'] = "#FF0000";
					$data['result']['text'] = $this->lang->line('login_missing_fields');
				
			}
			
		}
		
		$this->load->view('welcome_login', $data);
		
	}
	
	public function logout() {
		
		if (!$_SESSION['ci_session']) {
			
			redirect('welcome/login');
			
		}
		
		$this->session->sess_destroy();
		redirect('welcome/login');
		
	}
	
}
