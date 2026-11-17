<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Cart_service
{
	const MAX_QUANTITY = 99;

	protected $CI;

	public function __construct()
	{
		$this->CI =& get_instance();
		$this->CI->load->model('cart_model');
	}

	public function currency()
	{
		return strtolower(getenv('APP_CURRENCY') ?: 'usd');
	}


	public function items($user_id)
	{
		return $this->CI->cart_model->items_for_user((int) $user_id);
	}


	public function summary($user_id)
	{
		$items    = $this->items($user_id);
		$count    = 0;
		$subtotal = 0;

		foreach ($items as $item) {
			$count    += (int) $item->quantity;
			$subtotal += (int) $item->line_total;
		}

		return array(
			'items'    => $items,
			'count'    => $count,
			'subtotal' => $subtotal,
			'currency' => $this->currency(),
		);
	}


	public function count($user_id)
	{
		return $this->CI->cart_model->total_quantity((int) $user_id);
	}


	public function add($user_id, $product_id, $quantity = 1)
	{
		$quantity = $this->validate_quantity($quantity, 1);

		if ( ! $this->CI->cart_model->product_is_available((int) $product_id)) {
			throw new CartException('This product is not available.');
		}

		$this->CI->cart_model->add_or_increment((int) $user_id, (int) $product_id, $quantity, self::MAX_QUANTITY);
	}


	public function update($user_id, $product_id, $quantity)
	{
		$quantity = $this->validate_quantity($quantity, 0);

		if ($quantity === 0) {
			$this->remove($user_id, $product_id);
			return;
		}

		if ( ! $this->CI->cart_model->find_item((int) $user_id, (int) $product_id)) {
			throw new CartException('This product is not in your cart.');
		}

		$this->CI->cart_model->set_quantity((int) $user_id, (int) $product_id, $quantity);
	}

	public function remove($user_id, $product_id)
	{
		$this->CI->cart_model->delete_item((int) $user_id, (int) $product_id);
	}

	public function clear($user_id)
	{
		$this->CI->cart_model->delete_all((int) $user_id);
	}


	public function remove_products($user_id, array $product_ids)
	{
		if ( ! empty($product_ids)) {
			$this->CI->cart_model->delete_products((int) $user_id, array_map('intval', $product_ids));
		}
	}


	protected function validate_quantity($quantity, $min)
	{
		if ( ! is_numeric($quantity) || (int) $quantity != $quantity) {
			throw new CartException('Quantity must be a whole number.');
		}

		$quantity = (int) $quantity;

		if ($quantity < $min) {
			throw new CartException('Quantity must be at least ' . $min . '.');
		}
		if ($quantity > self::MAX_QUANTITY) {
			throw new CartException('You can order at most ' . self::MAX_QUANTITY . ' of one product.');
		}

		return $quantity;
	}
}


class CartException extends RuntimeException {}
