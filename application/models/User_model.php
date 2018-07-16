<?php

class User_model extends CI_Model {
	
	function __construct() {
		
		parent::__construct();
		
	}
	
	public function getEmployee($eid) {
		
		return $this->db->query("SELECT `eid`,`username`,`created`,`last_login`,`last_punch`,`name_first`,`name_last`,`slack`,`level` FROM `employees` WHERE `eid` = '".$eid."'")->row();
		
	}
	
	public function getEmployees() {
		
		return $this->db->query("SELECT * FROM `employees` ORDER BY `name_first` ASC, `name_last` ASC")->result_array();
		
	}
	
	public function getNotifications($eid) {
		
		$eid = $this->db->escape($eid);
		$notifications = $this->db->query("SELECT * FROM `notifications` WHERE `seen` = '0' AND `eid` = ".$eid." ORDER BY `nid` DESC")->result_array();
		
		$i=0;
		foreach ($notifications AS $notification) {
			
			switch ($notification['type']) {
									
				case "task-add":
					$link = site_url('tasks/view/'.$notify['tid']);
					$icon = "fa-plus";
					$style = "label-success";
					break;
					
				case "task-del":
					$link = site_url('tasks/view/'.$notify['tid']);
					$icon = "fa-minus";
					$style = "label-danger";
					break;
					
				case "task-mod":
					$link = site_url('tasks/view/'.$notify['tid']);
					$icon = "fa-pencil";
					$style = "label-warning";
					break;
					
				default:
					$link = site_url('welcome');
					$icon = "fa-check";
					$icon = "label-primary";
					break;
				
			}
			
			$return[$i]['nid'] = $notification['nid'];
			$return[$i]['eid'] = $notification['eid'];
			$return[$i]['content'] = $notification['content'];
			$return[$i]['type'] = $notification['type'];
			$return[$i]['seen'] = $notification['seen'];
			$return[$i]['timestamp'] = $notification['timestamp'];
			$return[$i]['link'] = $link;
			$return[$i]['icon'] = $icon;
			$return[$i]['style'] = $style;
			
			$noptions = $this->db->query("SELECT * FROM `notifications_options` WHERE `nid` = '".$notification['nid']."'")->result_array();
			foreach ($noptions AS $option) {
				
				$return[$i][$option['option_name']] = $option['option_value'];
				
			}
			
			$i++;
			
		}
		
		return $return;
		
	}
	
	public function dolog($eid, $action) {
		
		$action = $this->db->escape($action);
		$this->db->query("INSERT INTO `logs` SET `eid` = '".$eid."', `content` = ".$action.", `timestamp` = UNIX_TIMESTAMP");
		
		return "1";
		
	}
	
	public function notify($eid, $content) {
		
		$content = $this->db->escape($content);
		$this->db->query("INSERT INTO `notifications` SET `eid` = '".$eid."', `content` = ".$content.", `timestamp` = UNIX_TIMESTAMP()");
		
		return $this->db->insert_id();
		
	}
	
}