<?php

class Welcome_model extends CI_Model {
	
	function __construct() {
		
		parent::__construct();
		
	}
	
	public function login($username, $password) {
		
		$username = $this->db->escape($username);
		$password = $this->db->escape($password);
		
		$query = "SELECT `eid`,`username`,`created`,`last_login`,`last_punch`,`name_first`,`name_last`,`slack`,`level` FROM `employees` ";
		$query .= "WHERE `username` = ".$username." AND `password` = md5(".$password.")";
		$user = $this->db->query($query)->row();
		
		if ($user) {
			
			$_SESSION['ci_session'] = $user;
			$this->db->query("UPDATE `employees` SET `last_login` = UNIX_TIMESTAMP() WHERE `eid` = '".$user->eid."'");
			return $user;
			
		} else {
			
			return false;
			
		}
		
	}
	
}