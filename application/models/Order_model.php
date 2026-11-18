<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Order_model extends CI_Model
{
	//statuses of the order
	const STATUS_PENDING   = 'pending';
	const STATUS_PAID      = 'paid';
	const STATUS_FAILED    = 'failed';
	const STATUS_CANCELLED = 'cancelled';
	const STATUS_EXPIRED   = 'expired';

	public function create($user_id, $total_amount, $currency)
	{
		$this->db->insert('orders', array(
			'user_id'      => $user_id,
			'status'       => self::STATUS_PENDING,
			'total_amount' => $total_amount,
			'currency'     => $currency,
		));

		return (int) $this->db->insert_id();
	}

	public function add_details($order_id, array $items)
	{
		$rows = array();
		foreach ($items as $item) {
			$rows[] = array(
				'order_id'     => $order_id,
				'product_id'   => (int) $item->product_id,
				'product_name' => $item->name,
				'unit_price'   => (int) $item->price,
				'quantity'     => (int) $item->quantity,
				'line_total'   => (int) $item->line_total,
			);
		}

		return $this->db->insert_batch('order_details', $rows);
	}

	public function find($id)
	{
		return $this->db->get_where('orders', array('id' => (int) $id), 1)->row();
	}


	public function find_for_update($id)
	{
		return $this->db
			->query('SELECT * FROM orders WHERE id = ? FOR UPDATE', array((int) $id))
			->row();
	}

	public function find_by_session($session_id)
	{
		return $this->db
			->get_where('orders', array('stripe_checkout_session_id' => $session_id), 1)
			->row();
	}

	public function details($order_id)
	{
		return $this->db
			->order_by('id', 'ASC')
			->get_where('order_details', array('order_id' => (int) $order_id))
			->result();
	}

	public function set_checkout_session($id, $session_id)
	{
		return $this->db
			->where('id', (int) $id)
			->update('orders', array('stripe_checkout_session_id' => $session_id));
	}

	public function mark_paid($id)
	{
		$this->db->set('paid_at', 'UTC_TIMESTAMP()', FALSE);

		return $this->db
			->where('id', (int) $id)
			->update('orders', array('status' => self::STATUS_PAID));
	}


	public function set_status($id, $status, $only_if = self::STATUS_PENDING)
	{
		$this->db
			->where('id', (int) $id)
			->where('status', $only_if)
			->update('orders', array('status' => $status));

		return $this->db->affected_rows() > 0;
	}
}
