<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Product_model extends CI_Model
{
	const TABLE = 'products';
	const DEFAULT_CURRENCY = 'SGD';


	protected $public_columns = 'id, name, description, price, currency, is_active, image, created_at, updated_at';


	public function find($id)
	{
		return $this->db
			->select($this->public_columns)
			->get_where(self::TABLE, array('id' => (int) $id), 1)
			->row();
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




	protected function apply_filters(array $filters)
	{
		if (! empty($filters['search'])) {
			$this->db->group_start()
				->like('name', $filters['search'])
				->or_like('description', $filters['search'])
				->group_end();
		}
	}


	public function create(array $data)
	{
		$row = array(
			'name'          => trim($data['name']),
			'description'   => trim($data['description']),
			'price' 		=> $data['price'],
			'currency'      => isset($data['currency']) ? $data['currency'] : self::DEFAULT_CURRENCY,
			'is_active'     => isset($data['is_active']) ? (int) (bool) $data['is_active'] : 1,
			'image'        => isset($data['image']) ? $data['image'] : NULL,
		);

		if (! $this->db->insert(self::TABLE, $row)) {
			return FALSE;
		}

		return (int) $this->db->insert_id();
	}


	public function update($id, array $data)
	{
		$row = array();

		if (isset($data['name'])) $row['name'] = trim($data['name']);
		if (isset($data['description'])) $row['description'] = trim($data['description']);
		if (isset($data['price'])) $row['price'] = $data['price'];
		if (isset($data['currency'])) $row['currency'] = $data['currency'];
		if (isset($data['is_active'])) $row['is_active'] = (int) (bool) $data['is_active'];
		if (array_key_exists('image', $data)) $row['image'] = $data['image'];   // allows NULL (remove avatar)

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
			->update('products', array('is_active' => $active ? 1 : 0));
	}
}
