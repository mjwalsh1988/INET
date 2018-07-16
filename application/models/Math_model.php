<?php

class Math_model extends CI_Model {
	
	function __construct() {
		
		parent::__construct();
		
	}
	
	private function getWeekStart($timestamp) {
		
		$dayofweek = date('w', $timestamp);
		$createstart = strtotime('last Sunday', $timestamp);
		
		if ($dayofweek == 0) {
			
			$weekstart = date('Y-m-d', $timestamp);
				
		} else {
			
			$weekstart = date('Y-m-d', $createstart);
			
		}
		
		return $weekstart;
		
	}
	
	public function countTime($dateStart, $dateEnd, $eid) {
		
		$days = $this->db->query("SELECT `date` FROM `punches` WHERE `eid` = '".$eid."' AND `date` >= '".$dateStart."' AND `date` <= '".$dateEnd."' GROUP BY `date`")->result_array();
		$punches = $this->db->query("SELECT * FROM `punches` WHERE `eid` = '".$eid."' AND `date` >= '".$dateStart."' AND `date` <= '".$dateEnd."' ORDER BY `timestamp` ASC")->result_array();
		
		$array = array();
		foreach ($punches AS $punch) {
			
			$array[$punch['date']][$punch['action']][] = $punch['timestamp'];
			
		}
		
		foreach ($array AS $day => $dayArray) {
			
			$array[$day]['total_seconds'] = 0;
			$array[$day]['total'] = "";
			foreach ($dayArray['In'] AS $id => $timestamp) {
			
				if ($array[$day]['Out'][$id] > 0 && $array[$day]['In'][$id] > 0) {

					$seconds = $array[$day]['Out'][$id] - $array[$day]['In'][$id];
					
					$array[$day]['total_seconds'] = $array[$day]['total_seconds'] + $seconds;
					
					
				} else {
					
					$array[$day]['total_seconds'] = $array[$day]['total_seconds'] + 0;
					
				}
				
			}
			
			$seconds = $array[$day]['total_seconds'];
			$hours = round((($seconds / 60) / 60), 2);
			
			$array[$day]['total'] = $hours;
			
		}
		
		foreach ($array AS $day => $dayArray) {
			
			$first_day = $day;
			break;
			
		}
		
		if (date('l', strtotime($day)) == "Friday" || date('l', strtotime($day)) == "Saturday") {
			
			$weekstart = $this->getWeekStart(strtotime($day));
			$currentday = $weekstart;
			
			for ($i=0; $i<=7; $i++) {
				
				
				
			}
			
		}
		
		return $array;
		
	}
	
}