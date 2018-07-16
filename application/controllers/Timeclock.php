<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Timeclock extends CI_Controller {
	
	public function __construct() {
		
		parent::__construct();
		if (!$_SESSION['ci_session']) {
			
			redirect('welcome/login');
			
		}
		$this->lang->load(array('timeclock','misc'), 'english');
		
	}

	public function index() {
		
		$data['session'] = $this->session->userdata('ci_session');		
		$data['user'] = $this->User_model->getEmployee($data['session']->eid);
		
		$config = array(
		
			'start_date' 	=> 'Sunday',
			'month_type'	=> 'long',
			'day_type'		=> 'long',
			'template' 		=> '{table_open}<table border="0" cellpadding="5" cellspacing="2" width="100%" class="calendar">{/table_open}
	
			{heading_row_start}<tr>{/heading_row_start}
	
			{heading_previous_cell}<th><a href="{previous_url}">&lt;&lt;</a></th>{/heading_previous_cell}
			{heading_title_cell}<th colspan="{colspan}">{heading}</th>{/heading_title_cell}
			{heading_next_cell}<th><a href="{next_url}">&gt;&gt;</a></th>{/heading_next_cell}
	
			{heading_row_end}</tr>{/heading_row_end}
	
			{week_row_start}<tr>{/week_row_start}
			{week_day_cell}<td class="week">{week_day}</td>{/week_day_cell}
			{week_row_end}</tr>{/week_row_end}
	
			{cal_row_start}<tr>{/cal_row_start}
			{cal_cell_start}<td>{/cal_cell_start}
			{cal_cell_start_today}<td>{/cal_cell_start_today}
			{cal_cell_start_other}<td class="other-month">{/cal_cell_start_other}
	
			{cal_cell_content}<span>{day}</span><br/><br/><center>{content}</center>{/cal_cell_content}
			{cal_cell_content_today}<span class="highlight">{day}</span><br/><br/><center>{content}</center>{/cal_cell_content_today}
	
			{cal_cell_no_content}<span>{day}</span>{/cal_cell_no_content}
			{cal_cell_no_content_today}<span class="highlight">{day}</span>{/cal_cell_no_content_today}
	
			{cal_cell_blank}&nbsp;{/cal_cell_blank}
	
			{cal_cell_other}{day}{cal_cel_other}
	
			{cal_cell_end}</td>{/cal_cell_end}
			{cal_cell_end_today}</td>{/cal_cell_end_today}
			{cal_cell_end_other}</td>{/cal_cell_end_other}
			{cal_row_end}</tr>{/cal_row_end}
	
			{table_close}</table>{/table_close}'
			
		);
		$this->load->library('calendar', $config);
		$this->load->model('Timeclock_model');
		$data['last_punch'] = $this->Timeclock_model->getPunch($data['user']->last_punch);
		$data['hours'] = $this->Math_model->countTime(date('Y-m-01'), date('Y-m-t'), $data['user']->eid);
		
		//echo"<pre>"; print_r($data['hours']); echo"</pre>";
		
		$data['calendar'] = array();
		foreach ($data['hours'] AS $day => $dayArray) {
			
			$day = explode("-", $day);
			$data['calendar'][$day[2]] = $dayArray['total']." ".$this->lang->line('hours');
			
		}
		
		if ($data['last_punch']->action == "In") {
			
			$data['clock_status'] = 1;
			
		} else {
			
			$data['clock_status'] = 0;
			
		}
		
		$data['punch_difference'] = (time() - $data['last_punch']->timestamp) * 1000;
		
		$this->load->view('header');
		$this->load->view('timeclock', $data);
		$this->load->view('footer');
		
	}
	
	public function punch() {
		
		$this->load->model('Timeclock_model');
		$this->Timeclock_model->punch($_SESSION['ci_session']->eid);
		
		redirect('welcome');
		
	}
	
}
