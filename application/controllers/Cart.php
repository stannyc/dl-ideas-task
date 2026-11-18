<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cart extends User_Controller
{
	public function __construct()
	{
		parent::__construct();   // login check
		$this->load->library('cart_service');
	}

	public function index()
	{
		$cart = $this->cart_service->summary($this->current_user->id);

		$this->render('cart/index', array(
			'title'    => 'Shopping cart',
			'items'    => $cart['items'],      // product_id, quantity, name, price, image, line_total (in cents)
			'count'    => $cart['count'],
			'subtotal' => $cart['subtotal'],   // cents
			'currency' => $cart['currency'],
		));
	}

	public function add()
	{
		$this->_ensure_post();

		try {
			$this->cart_service->add(
				$this->current_user->id,
				$this->input->post('product_id'),
				$this->input->post('quantity') ?: 1
			);
			$this->session->set_flashdata('success', 'Added to your cart.');
		} catch (CartException $e) {
			$this->session->set_flashdata('error', $e->getMessage());
		}

		$this->session->set_flashdata('success', 'Product added to cart');
		redirect($this->_back_url('shop'));
	}

	public function update()
	{
		$this->_ensure_post();

		try {
			$this->cart_service->update(
				$this->current_user->id,
				$this->input->post('product_id'),
				$this->input->post('quantity')
			);
			$this->session->set_flashdata('success', 'Cart updated.');
		} catch (CartException $e) {
			$this->session->set_flashdata('error', $e->getMessage());
		}

		redirect('cart');
	}

	public function remove()
	{
		$this->_ensure_post();

		$this->cart_service->remove($this->current_user->id, $this->input->post('product_id'));
		$this->session->set_flashdata('success', 'Item removed.');

		redirect('cart');
	}

	public function clear()
	{
		$this->_ensure_post();

		$this->cart_service->clear($this->current_user->id);
		$this->session->set_flashdata('success', 'Your cart is now empty.');

		redirect('cart');
	}

	public function checkout()
	{
		$this->_ensure_post();

		try {
			
			$this->load->library('checkout_service');

			$result = $this->checkout_service->start(
				$this->current_user->id,				
				site_url('checkout/success') . '?session_id={CHECKOUT_SESSION_ID}',
				site_url('checkout/cancel')
			);

			redirect($result['checkout_url']);
		} catch (CheckoutException $e) {
			$this->session->set_flashdata('error', $e->getMessage());
			redirect('cart');
		} catch (RuntimeException $e) {			
			log_message('error', 'Checkout unavailable: ' . $e->getMessage());
			$this->session->set_flashdata('error', 'Checkout is temporarily unavailable. Please try again later.'.$e->getMessage());
			redirect('cart');
		}
	}


	protected function _ensure_post()
	{
		if ($this->input->method() !== 'post') {
			show_error('Method Not Allowed', 405);
		}
	}


	protected function _back_url($fallback)
	{
		$referer = (string) $this->input->server('HTTP_REFERER');

		if ($referer !== '' && strpos($referer, base_url()) === 0) {
			return $referer;
		}

		return $fallback;
	}
}
