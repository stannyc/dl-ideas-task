<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Health extends CI_Controller {

	public function index(){
		echo "System is up and running";
	}

	public function dbstatus(){
		$query =  $this->db->query("SELECT VERSION() as VERSION");
		$row =  $query->row();
		echo !empty($row->VERSION) ? 'Database up and running' : 'Database Down';
	}

}



?>
