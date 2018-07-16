<?php

class Ajax_model extends CI_Model {
	
	function __construct() {
		
		parent::__construct();
		
	}
	
	public function taskDelete($tid) {
		
		$tid = $this->db->escape($tid);
		$this->db->query("DELETE FROM `tasks` WHERE `tid` = ".$tid);
		$this->db->query("DELETE FROM `tasks_options` WHERE `tid` = ".$tid);
		
		$taskNotis = $this->db->query("SELECT `nid` FROM `notifications_options` WHERE `option_name` = 'tid' AND `option_value` = ".$tid)->result_array();
		foreach ($taskNotis AS $task) {
			
			$this->db->query("DELETE FROM `notifications_options` WHERE `nid` = '".$task['nid']."'");
			$this->db->query("DELETE FROM `notifications` WHERE `nid` = '".$task['nid']."'");
			
		}
		
		return TRUE;
		
	}
	
	public function taskTitle($id, $value) {
		
		$id = $this->db->escape($id);
		$value = $this->db->escape_str($value);
		
		$this->db->query("UPDATE `tasks` SET `title` = '".$value."' WHERE `tid` = ".$id);
		
		return $value;
		
	}
	
	public function taskStatus($id, $value) {
		
		$id = $this->db->escape($id);
		$value = $this->db->escape_str($value);
		
		$this->db->query("UPDATE `tasks_options` SET `option_value` = '".$value."' WHERE `tid` = ".$id." AND `option_name` = 'status'");
		$status = $this->db->query("SELECT `name` FROM `tasks_statuses` WHERE `tsid` = '".$value."'")->row_array();
		
		return $status['name'];
		
	}
	
	public function taskStatuses() {
		
		return $this->db->query("SELECT * FROM `tasks_statuses` ORDER BY `order` ASC")->result_array();
		
	}
	
	public function taskDue($id, $value) {
		
		$id = $this->db->escape($id);
		$value = $this->db->escape_str($value);
		
		$this->db->query("UPDATE `tasks_options` SET `option_value` = '".strtotime($value)."' WHERE `option_name` = 'due' AND `tid` = ".$id);
		
		return $value;
		
	}
	
	public function taskContent($id, $value) {
		
		$id = $this->db->escape($id);
		$value = $this->db->escape_str($value);
		
		$this->db->query("UPDATE `tasks` SET `content` = '".$value."' WHERE tid = ".$id);
		
		return $value;
		
	}
	
	public function taskAssign($id, $value) {
		
		$id = $this->db->escape_str($id);
		$current_assign = $this->db->query("SELECT * FROM `tasks_options` WHERE `tid` = '".$id."' AND `option_name` = 'assign'")->result_array();
		
		foreach ($current_assign AS $assign) {
			
			if (!in_array($assign['option_value'], $value)) {
				
				$this->db->query("DELETE FROM `tasks_options` WHERE `toid` = '".$assign['toid']."'");
				$content = "You were removed from the assigned employees on a task.";
				$this->db->query("INSERT INTO `notifications` SET `eid` = '".$assign['option_value']."', `content` = '".$content."', `type` = 'task-mod', `timestamp` = UNIX_TIMESTAMP()");
				$this->db->query("INSERT INTO `notifications_options` SET `nid` = '".$this->db->insert_id()."', `option_name` = 'tid', `option_value` = '".$id."'");
				
			} else {
				
				if (($key = array_search($assign['option_value'], $value)) !== FALSE) {
				
					unset($value[$key]);
					
				}
				
				$employee = $this->db->query("SELECT CONCAT(`name_first`, ' ', `name_last`) AS name FROM `employees` WHERE `eid` = '".$assign['option_value']."'")->row_array();
				$return[] = $employee['name'];
				
			}
			
		}
		
		foreach ($value AS $eid) {
			
			$eid = $this->db->escape_str($eid);
			$this->db->query("INSERT INTO `tasks_options` SET `tid` = '".$id."', `option_name` = 'assign', `option_value` = '".$eid."'");
			$employee = $this->db->query("SELECT CONCAT(`name_first`, ' ', `name_last`) AS name FROM `employees` WHERE `eid` = '".$eid."'")->row_array();
			$content = "You were recently added to the assigned employees list for a task.";
			$this->db->query("INSERT INTO `notifications` SET `eid` = '".$eid."', `content` = '".$content."', `type` = 'task-mod', `timestamp` = UNIX_TIMESTAMP()");
			$this->db->query("INSERT INTO `notifications_options` SET `nid` = '".$this->db->insert_id()."', `option_name` = 'tid', `option_value` = '".$id."'");
			$return[] = $employee['name'];
			
		}
		
		$content = "modified assigned employees on task # <a href=\"".site_url('tasks/view/'.$id)."\" target=\"_blank\">".$id."</a>.";
		$this->db->query("INSERT INTO `logs` SET `eid` = '".$_SESSION['ci_session']->eid."', `content` = '".$content."', `timestamp` = UNIX_TIMESTAMP()");
		
		return implode("<br/>", $return);
		
	}
	
	public function notificationRead($nid) {
		
		$nid = $this->db->escape($nid);
		
		$this->db->query("UPDATE `notifications` SET `seen` = '1' WHERE `nid` = ".$nid);
		
		return TRUE;
		
	}
	
}