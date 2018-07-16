<?php

class Timeclock_model extends CI_Model {
	
	function __construct() {
		
		parent::__construct();
		
	}
	
	private function clock_status($eid) {
		
		$punch = $this->db->query("SELECT * FROM `punches` WHERE `eid` = '".$eid."' ORDER BY `timestamp` DESC LIMIT 1")->row();
		
		if ($punch) {
			
			return $punch;
			
		} else {
			
			return 0;
			
		}
		
	}
	
	public function punch($eid) {
		
		$status = $this->clock_status($eid);
		
		if ($status->action == "Out") {
			
			$this->db->query("INSERT INTO `punches` SET `eid` = '".$eid."', `timestamp` = UNIX_TIMESTAMP(), `date` = '".date('Y-m-d')."', `action` = 'In'");
			
		} else if ($status->action == "In") {
			
			$this->db->query("INSERT INTO `punches` SET `eid` = '".$eid."', `timestamp` = UNIX_TIMESTAMP(), `date` = '".date('Y-m-d')."', `action` = 'Out'");
			
		} else {
			
			$this->db->query("INSERT INTO `punches` SET `eid` = '".$eid."', `timestamp` = UNIX_TIMESTAMP(), `date` = '".date('Y-m-d')."', `action` = 'In'");
			
		}
		
		$this->db->query("UPDATE `employees` SET `last_punch` = '".$this->db->insert_id()."' WHERE `eid` = '".$eid."'");
		
	}
	
	public function getPunch($pid) {
		
		return $this->db->query("SELECT * FROM `punches` WHERE `pid` = '".$pid."'")->row();
		
	}
	
	public function getPunches($eid, $num = 0) {
		
		return $this->db->query("SELECT * FROM `punches` WHERE `eid` = '".$eid."' ORDER BY `timestamp` DESC LIMIT ".$num)->result_array();
		
	}
	
}