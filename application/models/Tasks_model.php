<?php

class Tasks_model extends CI_Model {
	
	function __construct() {
		
		parent::__construct();
		
	}
	
	public function addTask($array) {
		
		/* CLEAN VARIABLES */
		foreach ($array AS $id => $val) {
			$array[$id] = $this->db->escape_str($val);
		}
		$due = strtotime($array['due']);
		
		/* INSERT TASK */
		$this->db->query("INSERT INTO `tasks` SET `title` = '".$array['title']."', `content` = '".$array['content']."', `timestamp` = UNIX_TIMESTAMP()");
		$tid = $this->db->insert_id();
		
		$this->db->query("INSERT INTO `tasks_options` SET `tid` = '".$tid."', `option_name` = 'status', `option_value` = '".$array['status']."'");
		$this->db->query("INSERT INTO `tasks_options` SET `tid` = '".$tid."', `option_name` = 'due', `option_value` = '".$due."'");
		$this->db->query("INSERT INTO `tasks_options` SET `tid` = '".$tid."', `option_name` = 'author', `option_value` = '".$_SESSION['ci_session']->eid."'");
		foreach ($array['assign'] AS $employee) {
			
			$this->db->query("INSERT INTO `tasks_options` SET `tid` = '".$tid."', `option_name` = 'assign', `option_value` = '".$employee."'");
			
			/* INSERT NOTIFICATIONS AS NEEDED */
			$content = "There was a new task (".$array['title'].") added that you are assigned to, please check this at your earliest convenience!";
			$this->db->query("INSERT INTO `notifications` SET `eid` = '".$employee."', `content` = '".$content."', `type` = 'task-add', timestamp = UNIX_TIMESTAMP()");
			$nid = $this->db->insert_id();
			$this->db->query("INSERT INTO `notifications_options` SET `nid` = '".$nid."', `option_name` = 'tid', `option_value` = '".$tid."'");
			
		}		
		
		return $this->db->insert_id();
		
	}
	
	public function getStatuses($simple = 0) {
		
		$query = $this->db->query("SELECT * FROM `tasks_statuses` ORDER BY `order` ASC")->result_array();
		if ($simple == 1) {
			
			$return = array();
			foreach ($query AS $status) {
				
				$return[$status['tsid']] = $status['name'];
				
			}
			
		} else {
			
			$return = $query;
			
		}
		
		return $return;
		
	}
	
	public function getTask($tid) {
		
		$this->db->select('*');
		$this->db->from('tasks');
		$this->db->where('tid', $tid);
		$task = $this->db->get()->row_array();
		
		$options = $this->db->query("SELECT * FROM `tasks_options` WHERE `tid` = '".$task['tid']."'")->result_array();
		foreach ($options AS $toarr) {
			
			if ($toarr['option_name'] == "assign") {
				
				$employee = $this->db->query("SELECT CONCAT(name_first, ' ', name_last) AS name FROM `employees` WHERE `eid` = '".$toarr['option_value']."'")->row_array();
				$array['assign'][] = $employee['name'];
				$array['assignid'][] = $toarr['option_value'];
				
			} elseif ($toarr['option_name'] == "status") {
				
				$status = $this->db->query("SELECT `name`,`tsid` FROM `tasks_statuses` WHERE `tsid` = '".$toarr['option_value']."'")->row_array();
				$array['tsid'] = $status['tsid'];
				$array[$toarr['option_name']] = $status['name'];
				
			} elseif ($toarr['option_name'] == "author") {
				
				$employee = $this->db->query("SELECT CONCAT(name_first, ' ', name_last) AS name FROM `employees` WHERE `eid` = '".$toarr['option_value']."'")->row_array();
				$array['author'] = $employee['name'];
				
			} else {
				
				$array[$toarr['option_name']] = $toarr['option_value'];
				
			}
			
		}
		
		$array['tid'] = $task['tid'];
		$array['title'] = $task['title'];
		$array['content'] = $task['content'];
		$array['timestamp'] = $task['timestamp'];
		
		return $array;
		
	}
	
	public function getTasks($employee = 'all', $status = 'all') {
		
		$this->db->select('t.*');
		$this->db->from('tasks AS t');
		$this->db->join('tasks_options AS to', 't.tid = to.tid', 'full');
		if ($employee != 'all') {
			$this->db->join('tasks_options AS to2', 't.tid = to2.tid', 'full');
			$this->db->where('to2.option_name', 'assign');
			$this->db->where('to2.option_value', $employee);
		}
		if ($status != 'all') {
			$this->db->where('to.option_name', 'status');
			$this->db->where('to.option_value', $status);
		}
		$this->db->group_by('t.tid');
		
		$array = array();
		foreach ($this->db->get()->result_array() AS $id => $arr) {
			
			$array[$arr['tid']]['tid'] = $arr['tid'];
			$array[$arr['tid']]['title'] = $arr['title'];
			$array[$arr['tid']]['content'] = $arr['content'];
			$array[$arr['tid']]['timestamp'] = $arr['timestamp'];
			
			$options = $this->db->query("SELECT * FROM `tasks_options` WHERE `tid` = '".$arr['tid']."'")->result_array();
			foreach ($options AS $toarr) {
				
				if ($toarr['option_name'] == "assign") {
					
					$employee = $this->db->query("SELECT CONCAT(name_first, ' ', name_last) AS name FROM `employees` WHERE `eid` = '".$toarr['option_value']."'")->row_array();
					$array[$arr['tid']]['assign'][] = $employee['name'];
					
				} elseif ($toarr['option_name'] == "status") {
					
					$status = $this->db->query("SELECT `name` FROM `tasks_statuses` WHERE `tsid` = '".$toarr['option_value']."'")->row_array();
					$array[$arr['tid']][$toarr['option_name']] = $status['name'];
					
				} elseif ($toarr['option_name'] == "author") {
					
					$employee = $this->db->query("SELECT CONCAT(name_first, ' ', name_last) AS name FROM `employees` WHERE `eid` = '".$toarr['option_value']."'")->row_array();
					$array[$arr['tid']]['author'] = $employee['name'];
					
				} else {
					
					$array[$arr['tid']][$toarr['option_name']] = $toarr['option_value'];
					
				}
				
			}
			
		}
		
		return $array;
		
	}
	
}