<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migrate extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();

		if (!is_cli()) {
			show_404();
		}

		$this->load->library('migration');
	}


	public function index()
	{
		$version = $this->migration->latest();

		if ($version === FALSE) {
			echo $this->migration->error_string();
			exit(1);
		}

		echo "Migrated to version: {$version}" . PHP_EOL;
	}

	public function version($target)
	{
		$version = $this->migration->version((int) $target);

		if ($version === FALSE) {
			echo $this->migration->error_string();
			exit(1);
		}

		echo "Migrated to version: {$version}" . PHP_EOL;
	}
}
