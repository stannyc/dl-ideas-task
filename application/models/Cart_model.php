<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cart_model extends CI_Model
{
	const TABLE = 'cart_items';

	public function items_for_user($user_id)
	{
		return $this->db
			->select('ci.product_id, ci.quantity, p.name, p.price, p.image, (p.price * ci.quantity) AS line_total', FALSE)
			->from(self::TABLE . ' ci')
			->join('products p', 'p.id = ci.product_id')
			->where('ci.user_id', $user_id)
			->where('p.is_active', 1)
			->order_by('ci.created_at', 'ASC')
			->order_by('ci.id', 'ASC')
			->get()
			->result();
	}

	public function total_quantity($user_id)
	{
		$row = $this->db
			->select('COALESCE(SUM(ci.quantity), 0) AS total', FALSE)
			->from(self::TABLE . ' ci')
			->join('products p', 'p.id = ci.product_id')
			->where('ci.user_id', $user_id)
			->where('p.is_active', 1)
			->get()
			->row();

		return (int) $row->total;
	}

	public function find_item($user_id, $product_id)
	{
		return $this->db
			->get_where(self::TABLE, array('user_id' => $user_id, 'product_id' => $product_id), 1)
			->row();
	}

	public function product_is_available($product_id)
	{
		return $this->db
			->where(array('id' => $product_id, 'is_active' => 1))
			->count_all_results('products') > 0;
	}

	/**	 
	 * NOTE: "AS incoming" row alias needs MySQL 8.0.19+.
	 */
	public function add_or_increment($user_id, $product_id, $quantity, $max)
	{
		$sql = 'INSERT INTO ' . self::TABLE . ' (user_id, product_id, quantity)
		        VALUES (?, ?, ?) AS incoming
		        ON DUPLICATE KEY UPDATE quantity = LEAST(' . self::TABLE . '.quantity + incoming.quantity, ?)';

		return $this->db->query($sql, array($user_id, $product_id, $quantity, $max));
	}

	public function set_quantity($user_id, $product_id, $quantity)
	{
		return $this->db
			->where(array('user_id' => $user_id, 'product_id' => $product_id))
			->update(self::TABLE, array('quantity' => $quantity));
	}

	public function delete_item($user_id, $product_id)
	{
		return $this->db
			->where(array('user_id' => $user_id, 'product_id' => $product_id))
			->delete(self::TABLE);
	}

	public function delete_products($user_id, array $product_ids)
	{
		return $this->db
			->where('user_id', $user_id)
			->where_in('product_id', $product_ids)
			->delete(self::TABLE);
	}

	public function delete_all($user_id)
	{
		return $this->db
			->where('user_id', $user_id)
			->delete(self::TABLE);
	}
}
