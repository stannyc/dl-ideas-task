<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Receipt_model extends CI_Model
{
	
	public function create($invoice_id, $payment_intent_id, $amount_paid, $currency, $payment_method = NULL)
	{
		$this->db->set('paid_at', 'UTC_TIMESTAMP()', FALSE);
		$this->db->insert('receipts', array(
			'invoice_id'               => (int) $invoice_id,
			'receipt_number'           => 'REC-' . bin2hex(random_bytes(8)),
			'stripe_payment_intent_id' => $payment_intent_id,
			'amount_paid'              => (int) $amount_paid,
			'currency'                 => $currency,
			'payment_method'           => $payment_method,
		));

		$id = (int) $this->db->insert_id();

		$this->db
			->where('id', $id)
			->update('receipts', array('receipt_number' => sprintf('RCT-%s-%06d', date('Y'), $id)));

		return $id;
	}


	public function find($id)
	{
		return $this->db->get_where('receipts', array('id' => (int) $id), 1)->row();
	}


	public function find_by_invoice($invoice_id)
	{
		return $this->db->get_where('receipts', array('invoice_id' => (int) $invoice_id), 1)->row();
	}


	public function paginated($user_id = NULL, array $filters = array(), $per_page = 12, $page = 1)
	{
		if(!$user_id){
			unset($filters['user_id']);
		}
		return $this->_get_paginated_data($filters, $per_page, $page, TRUE);
	}



	protected function _get_paginated_data(array $filters, $per_page, $page, $internal)
	{
		$per_page = max(1, min(100, (int) $per_page));

		
		$this->_create_base_query($filters, $internal);
		$total = (int) $this->db->count_all_results();

		$last_page = max(1, (int) ceil($total / $per_page));
		$page      = min(max(1, (int) $page), $last_page);
		$offset    = ($page - 1) * $per_page;

		
		$columns = 'r.id, r.receipt_number, r.invoice_id, r.amount_paid, r.currency, r.payment_method, r.paid_at,
		            i.invoice_number, i.order_id, o.user_id, u.name AS user_name, u.email AS user_email';
		if ($internal) {
			$columns .= ', r.stripe_payment_intent_id';
		}

		$this->_create_base_query($filters, $internal);
		$items = $this->db
			->select($columns)
			->order_by('r.paid_at', 'DESC')
			->order_by('r.id', 'DESC')
			->limit($per_page, $offset)
			->get()
			->result();

		return array(
			'items'      => $items,
			'pagination' => $this->_generate_pagination($total, $per_page, $page, $offset, count($items)),
		);
	}

	protected function _create_base_query(array $filters, $internal)
	{
		$this->db
			->from('receipts r')
			->join('invoices i', 'i.id = r.invoice_id')
			->join('orders o', 'o.id = i.order_id')
			->join('users u', 'u.id = o.user_id');

		if (isset($filters['user_id'])) {
			$this->db->where('o.user_id', (int) $filters['user_id']);
		}

		if ( ! empty($filters['search'])) {
			$this->db->group_start()
				->like('r.receipt_number', $filters['search'])
				->or_like('i.invoice_number', $filters['search'])
				->or_like('u.name', $filters['search'])
				->or_like('u.email', $filters['search']);

			if ($internal) {				
				$this->db->or_like('r.stripe_payment_intent_id', $filters['search']);
			}

			$this->db->group_end();
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
