<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Invoice_model extends CI_Model
{
	const STATUS_UNPAID = 'unpaid';
	const STATUS_PAID   = 'paid';
	const STATUS_VOID   = 'void';




	public function create_for_order($order_id, $amount, $currency)
	{
		$this->db->insert('invoices', array(
			'order_id'       => (int) $order_id,
			'invoice_number' => 'INV-' . bin2hex(random_bytes(8)),
			'amount'         => (int) $amount,
			'currency'       => $currency,
			'status'         => self::STATUS_UNPAID,
		));

		$id = (int) $this->db->insert_id();

		//uodate the invoice number to get a unique numbering based on timestamp
		$this->db
			->where('id', $id)
			->update('invoices', array('invoice_number' => sprintf('INV-%s-%06d', date('Y'), $id)));
		
		//return invoice id
		return $id;
	}

	public function find($id)
	{
		$this->_generate_base_query([]);
		$q = $this->db
			->select('i.id, COALESCE(r.id) AS receipt_id, i.invoice_number, i.order_id, i.amount, i.currency, i.status, i.issued_at, i.paid_at,
			          o.user_id, u.name AS user_name, u.email AS user_email')->where('i.id', $id)->get()->result();
		return $q[0];
		//return $this->db->get_where('invoices', array('id' => (int) $id), 1)->row();
	}

	public function find_by_order($order_id)
	{
		return $this->db->get_where('invoices', array('order_id' => (int) $order_id), 1)->row();
	}

	public function mark_paid($id)
	{
		$this->db->set('paid_at', 'UTC_TIMESTAMP()', FALSE);

		return $this->db
			->where('id', (int) $id)
			->update('invoices', array('status' => self::STATUS_PAID));
	}

	public function void_if_unpaid($id)
	{
		return $this->db
			->where('id', (int) $id)
			->where('status', self::STATUS_UNPAID)
			->update('invoices', array('status' => self::STATUS_VOID));
	}


	public function paginated(array $filters = array(), $user_id = NULL, $per_page = 12, $page = 1)
	{
		if($user_id == NULL){
			unset($filters['user_id']); 
		}

		return $this->_get_paginated_data($filters, $per_page, $page);
	}


	protected function _get_paginated_data(array $filters, $per_page, $page)
	{
		$per_page = max(1, min(100, (int) $per_page));

		
		$this->_generate_base_query($filters);
		$total = (int) $this->db->count_all_results();

		$last_page = max(1, (int) ceil($total / $per_page));
		$page      = min(max(1, (int) $page), $last_page);
		$offset    = ($page - 1) * $per_page;

		$this->_generate_base_query($filters);
		$items = $this->db
			->select('i.id, i.invoice_number, i.order_id, i.amount, i.currency, i.status, i.issued_at, i.paid_at,
			          o.user_id, u.name AS user_name, u.email AS user_email')
			->order_by('i.issued_at', 'DESC')
			->order_by('i.id', 'DESC')
			->limit($per_page, $offset)
			->get()
			->result();

		return array(
			'items'      => $items,
			'pagination' => $this->_generate_pagination($total, $per_page, $page, $offset, count($items)),
		);
	}	

	protected function _generate_base_query(array $filters)
	{
		$this->db
			->from('invoices i')
			->join('orders o', 'o.id = i.order_id')
			->join('receipts r', 'r.invoice_id = i.id', 'LEFT')
			->join('users u', 'u.id = o.user_id');

		if (isset($filters['user_id'])) {
			$this->db->where('o.user_id', (int) $filters['user_id']);
		}

		if ( ! empty($filters['status'])
			&& in_array($filters['status'], array(self::STATUS_UNPAID, self::STATUS_PAID, self::STATUS_VOID), TRUE)) {
			$this->db->where('i.status', $filters['status']);
		}

		if ( ! empty($filters['search'])) {
			$this->db->group_start()
				->like('i.invoice_number', $filters['search'])
				->or_like('u.name', $filters['search'])
				->or_like('u.email', $filters['search'])
			->group_end();
		}
	}

	protected function _generate_pagination($total, $per_page, $page, $offset, $count)
	{
		$last_page = max(1, (int) ceil($total / $per_page));

		return array(
			'total'        => $total,
			'per_page'     => $per_page,
			'current_page' => $page,
			'last_page'    => $last_page,
			'from'         => $total ? $offset + 1 : 0,
			'to'           => $offset + $count,
			'has_prev'     => $page > 1,
			'has_next'     => $page < $last_page,
		);
	}


}
