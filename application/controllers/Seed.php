<?php
defined('BASEPATH') or exit('No direct script access allowed');

//CLI only seeder for initial admin account
class Seed extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		if (! is_cli()) {
			show_404();
		}
	}

	public function index()
	{
		$this->admin();
	}

	public function admin()
	{
		$email    = strtolower(trim(getenv('SEED_ADMIN_EMAIL') ?: 'admin@example.com'));
		$password = getenv('SEED_ADMIN_PASSWORD') ?: 'admin12345';
		$name     = getenv('SEED_ADMIN_NAME') ?: 'Administrator';

		$exists = $this->db
			->where('email', $email)
			->count_all_results('users') > 0;

		if ($exists) {
			echo "Admin {$email} already exists, skipped." . PHP_EOL;
			return;
		}

		$ok = $this->db->insert('users', array(
			'name'          => $name,
			'email'         => $email,
			'password_hash' => password_hash($password, PASSWORD_DEFAULT),
			'role'          => 'admin',
			'is_active'     => 1,
		));

		if (! $ok) {
			$error = $this->db->error();
			fwrite(STDERR, 'Failed to create admin: ' . $error['message'] . PHP_EOL);
			exit(1);
		}

		echo "Admin created: {$email}" . PHP_EOL;
	}
}
