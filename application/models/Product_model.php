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
		$per_page = max(1, min(100, (int) $per_page));
		
		$this->apply_filters($filters);
		$total = (int) $this->db->count_all_results(self::TABLE);


		$last_page = max(1, (int) ceil($total / $per_page));
		
		$page      = min(max(1, (int) $page), $last_page);
		
		$offset    = ($page - 1) * $per_page;

		
		$this->apply_filters($filters);

		$items = $this->db
			->select($this->public_columns)
			->order_by('created_at', 'DESC')
			->order_by('id', 'DESC')
			->limit($per_page, $offset)
			->get(self::TABLE)
			->result();

		return array(
			'items'      => $items,
			'pagination' => array(
				'total'        => $total,
				'per_page'     => $per_page,
				'current_page' => $page,
				'last_page'    => $last_page,
				'from'         => $total ? $offset + 1 : 0,
				'to'           => $offset + count($items),
				'has_prev'     => $page > 1,
				'has_next'     => $page < $last_page,
			),
		);
	}




	protected function apply_filters(array $filters)
	{
		if (! empty($filters['search'])) {
			$this->db->group_start()
				->like('name', $filters['search'])
				->or_like('description', $filters['search'])
				->group_end();
		}

		if (!empty($filters['is_active'])) {
			$this->db->group_start()
				->where('is_active', (int) $filters['is_active'])
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
