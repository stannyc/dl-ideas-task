<?php
defined('BASEPATH') or exit('No direct script access allowed');


class User_model extends CI_Model
{
	const TABLE = 'users';
	const ROLE_ADMIN = 'admin';
	const ROLE_USER  = 'user';

	
	protected $public_columns = 'id, name, email, role, is_active, avatar, created_at, updated_at';

	public function find($id)
	{
		return $this->db
			->select($this->public_columns)
			->get_where(self::TABLE, array('id' => (int) $id), 1)
			->row();
	}
	
	public function find_active($id)
	{
		return $this->db
			->select($this->public_columns)
			->get_where(self::TABLE, array('id' => (int) $id, 'is_active' => 1), 1)
			->row();
	}

	public function find_active_by_email($email)
	{
		return $this->db
			->get_where(self::TABLE, array(
				'email'     => $this->normalize_email($email),
				'is_active' => 1,
			), 1)
			->row();
	}

	public function email_exists($email, $except_id = NULL)
	{
		$this->db->where('email', $this->normalize_email($email));

		if ($except_id !== NULL) {
			$this->db->where('id !=', (int) $except_id);
		}

		return $this->db->count_all_results(self::TABLE) > 0;
	}


	public function paginate(array $filters = array(), $per_page = 15, $page = 1)
	{
		$page   = max(1, (int) $page);
		$offset = ($page - 1) * $per_page;

		$this->apply_filters($filters);

		return $this->db
			->select($this->public_columns)
			->order_by('created_at', 'DESC')
			->order_by('id', 'DESC')
			->limit($per_page, $offset)
			->get(self::TABLE)
			->result();
	}

	public function count_filtered(array $filters = array())
	{
		$this->apply_filters($filters);

		return $this->db->count_all_results(self::TABLE);
	}

	protected function apply_filters(array $filters)
	{
		if ( ! empty($filters['search'])) {
			$this->db->group_start()
				->like('name', $filters['search'])
				->or_like('email', $filters['search'])
			->group_end();
		}

		if ( ! empty($filters['role']) && in_array($filters['role'], array(self::ROLE_ADMIN, self::ROLE_USER), TRUE)) {
			$this->db->where('role', $filters['role']);
		}

		if (isset($filters['is_active']) && $filters['is_active'] !== '') {
			$this->db->where('is_active', (int) $filters['is_active']);
		}
	}

	public function create(array $data)
	{
		$row = array(
			'name'          => trim($data['name']),
			'email'         => $this->normalize_email($data['email']),
			'password_hash' => password_hash($data['password'], PASSWORD_DEFAULT),
			'role'          => isset($data['role']) ? $data['role'] : self::ROLE_USER,
			'is_active'     => isset($data['is_active']) ? (int) (bool) $data['is_active'] : 1,
			'avatar'        => isset($data['avatar']) ? $data['avatar'] : NULL,
		);

		if ( ! $this->db->insert(self::TABLE, $row)) {
			return FALSE;
		}

		return (int) $this->db->insert_id();
	}

	public function update($id, array $data)
	{
		$row = array();

		if (isset($data['name']))      $row['name']      = trim($data['name']);
		if (isset($data['email']))     $row['email']     = $this->normalize_email($data['email']);
		if (isset($data['role']))      $row['role']      = $data['role'];
		if (isset($data['is_active'])) $row['is_active'] = (int) (bool) $data['is_active'];
		if (array_key_exists('avatar', $data)) $row['avatar'] = $data['avatar'];   // allows NULL (remove avatar)

		if ( ! empty($data['password'])) {
			$row['password_hash'] = password_hash($data['password'], PASSWORD_DEFAULT);
		}

		if (empty($row)) {
			return TRUE;   // nothing to change
		}

		return $this->db
			->where('id', (int) $id)
			->update(self::TABLE, $row);
	}
	
	public function set_active($id, $active)
	{
		return $this->db
			->where('id', (int) $id)
			->update(self::TABLE, array('is_active' => $active ? 1 : 0));
	}

	public function rehash_password_if_needed($user, $plain_password)
	{
		if (password_needs_rehash($user->password_hash, PASSWORD_DEFAULT)) {
			$this->db
				->where('id', (int) $user->id)
				->update(self::TABLE, array('password_hash' => password_hash($plain_password, PASSWORD_DEFAULT)));
		}
	}

	public function count_by_role($role)
	{
		return $this->db
			->where('role', $role)
			->where('is_active', 1)
			->count_all_results(self::TABLE);
	}

	protected function normalize_email($email)
	{
		return strtolower(trim((string) $email));
	}
}
