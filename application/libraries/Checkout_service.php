<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Checkout_service
{
	
	const MINIMUM_AMOUNT = 50; //in cent

	protected $CI;
	protected $stripe;

	public function __construct()
	{
		$this->CI =& get_instance();

		$this->CI->load->library('cart_service');
		$this->CI->load->model(array('user_model', 'order_model', 'invoice_model', 'receipt_model'));

		$secret = getenv('STRIPE_SECRET_KEY');
		if ( ! $secret) {
			throw new RuntimeException('STRIPE_SECRET_KEY is not configured.');
		}
		$this->stripe = new \Stripe\StripeClient($secret);
	}


	public function start($user_id, $success_url, $cancel_url)
	{
		$user = $this->CI->user_model->find_active($user_id);
		if ( ! $user) {
			throw new CheckoutException('Your account is not active.');
		}

		$cart     = $this->CI->cart_service->summary($user_id);
		$items    = $cart['items'];
		$total    = $cart['subtotal'];
		$currency = $cart['currency'];

		if (empty($items)) {
			throw new CheckoutException('Your cart is empty.');
		}
		if ($total < self::MINIMUM_AMOUNT) {
			throw new CheckoutException('The order total is below the minimum amount for card payments.');
		}

		$this->CI->db->trans_start();
		$order_id   = $this->CI->order_model->create($user->id, $total, $currency);
		$this->CI->order_model->add_details($order_id, $items);
		$invoice_id = $this->CI->invoice_model->create_for_order($order_id, $total, $currency);
		$this->CI->db->trans_complete();

		if ($this->CI->db->trans_status() === FALSE) {
			log_message('error', 'Checkout: could not create order for user ' . $user->id);
			throw new CheckoutException('We could not create your order. Please try again.');
		}

		try {
			$session = $this->stripe->checkout->sessions->create(array(
				'mode'                => 'payment',
				'client_reference_id' => (string) $order_id,
				'customer_email'      => $user->email,
				'line_items'          => $this->to_stripe_line_items($items, $currency),
				'metadata'            => array('order_id' => $order_id, 'invoice_id' => $invoice_id),
				'payment_intent_data' => array(
					'metadata' => array('order_id' => $order_id, 'invoice_id' => $invoice_id),
				),
				'success_url'         => $success_url,
				'cancel_url'          => $cancel_url,
				'expires_at'          => time() + 3600,
				'adaptive_pricing'    => array('enabled' => FALSE),
			));
		} catch (\Stripe\Exception\ApiErrorException $e) {
			log_message('error', 'Checkout: Stripe session failed for order ' . $order_id . ': ' . $e->getMessage());
			$this->CI->order_model->set_status($order_id, Order_model::STATUS_FAILED);
			$this->CI->invoice_model->void_if_unpaid($invoice_id);
			throw new CheckoutException('The payment service is unavailable right now. Please try again.');
		}

		$this->CI->order_model->set_checkout_session($order_id, $session->id);

		return array(
			'order_id'     => $order_id,
			'invoice_id'   => $invoice_id,
			'session_id'   => $session->id,
			'checkout_url' => $session->url,
		);
	}

	public function complete($session)
	{
		$order = $this->CI->order_model->find_by_session($session->id);
		if ( ! $order) {
			throw new CheckoutException('No order found for checkout session ' . $session->id);
		}

		if ($session->payment_status !== 'paid') {
			return NULL; 
		}

		
		if ((int) $session->amount_total !== (int) $order->total_amount
			|| strtolower($session->currency) !== strtolower($order->currency)) {
			log_message('error', sprintf(
				'Checkout: amount mismatch for order %d (expected %d %s, Stripe %d %s)',
				$order->id, $order->total_amount, $order->currency, $session->amount_total, $session->currency
			));
			throw new CheckoutException('Payment amount does not match order ' . $order->id);
		}

		$payment_intent_id = is_string($session->payment_intent) ? $session->payment_intent : $session->payment_intent->id;
		$payment_method    = $this->describe_payment_method($payment_intent_id);

		$this->CI->db->trans_start();

		
		$locked  = $this->CI->order_model->find_for_update($order->id);
		$invoice = $this->CI->invoice_model->find_by_order($order->id);

		if ($locked->status === Order_model::STATUS_PAID) {
			$this->CI->db->trans_complete();
			$existing = $this->CI->receipt_model->find_by_invoice($invoice->id);
			return $existing ? (int) $existing->id : NULL;
		}

		$this->CI->order_model->mark_paid($order->id);
		$this->CI->invoice_model->mark_paid($invoice->id);
		$receipt_id = $this->CI->receipt_model->create(
			$invoice->id,
			$payment_intent_id,
			$session->amount_total,
			$session->currency,
			$payment_method
		);
		
		$product_ids = array();
		foreach ($this->CI->order_model->details($order->id) as $line) {
			$product_ids[] = (int) $line->product_id;
		}
		$this->CI->cart_service->remove_products($order->user_id, $product_ids);

		$this->CI->db->trans_complete();

		if ($this->CI->db->trans_status() === FALSE) {
			log_message('error', 'Checkout: failed to record payment for order ' . $order->id);
			throw new CheckoutException('Could not record payment for order ' . $order->id);
		}

		log_message('info', 'Checkout: order ' . $order->id . ' paid, receipt ' . $receipt_id);

		return $receipt_id;
	}

	
	//Session ended without payment
	public function expire($session)
	{
		return $this->close_unpaid($session, Order_model::STATUS_EXPIRED);
	}

	
	public function fail($session)
	{
		return $this->close_unpaid($session, Order_model::STATUS_FAILED);
	}
	
	public function cancel($user_id, $order_id)
	{
		$order = $this->CI->order_model->find($order_id);
		if ( ! $order || (int) $order->user_id !== (int) $user_id) {
			return FALSE;
		}

		if ($this->CI->order_model->set_status($order->id, Order_model::STATUS_CANCELLED)) {
			$invoice = $this->CI->invoice_model->find_by_order($order->id);
			if ($invoice) {
				$this->CI->invoice_model->void_if_unpaid($invoice->id);
			}
			return TRUE;
		}

		return FALSE;
	}



	public function sync($session_id)
	{
		try {
			$session = $this->stripe->checkout->sessions->retrieve($session_id);
		} catch (\Stripe\Exception\ApiErrorException $e) {
			log_message('error', 'Checkout: could not retrieve session ' . $session_id . ': ' . $e->getMessage());
			throw new CheckoutException('Could not check the payment status. Please refresh in a moment.');
		}

		if ($session->payment_status === 'paid') {
			$this->complete($session);
		}

		return $this->CI->order_model->find_by_session($session_id);
	}


	public function order_for_user_session($user_id, $session_id)
	{
		$order = $this->CI->order_model->find_by_session($session_id);

		return ($order && (int) $order->user_id === (int) $user_id) ? $order : NULL;
	}


	protected function close_unpaid($session, $status)
	{
		$order = $this->CI->order_model->find_by_session($session->id);
		if ( ! $order) {
			return FALSE;
		}


		if ($this->CI->order_model->set_status($order->id, $status)) {
			$invoice = $this->CI->invoice_model->find_by_order($order->id);
			if ($invoice) {
				$this->CI->invoice_model->void_if_unpaid($invoice->id);
			}
			return TRUE;
		}

		return FALSE;
	}

	protected function to_stripe_line_items(array $items, $currency)
	{
		$lines = array();
		foreach ($items as $item) {
			$lines[] = array(
				'quantity'   => (int) $item->quantity,
				'price_data' => array(
					'currency'     => $currency,
					'unit_amount'  => (int) $item->price,
					'product_data' => array('name' => $item->name),
				),
			);
		}
		return $lines;
	}


	protected function describe_payment_method($payment_intent_id)
	{
		try {
			$intent = $this->stripe->paymentIntents->retrieve($payment_intent_id, array('expand' => array('latest_charge')));
			$charge = $intent->latest_charge;

			if ($charge && isset($charge->payment_method_details->card)) {
				$card = $charge->payment_method_details->card;
				return ucfirst($card->brand) . '****' . $card->last4;
			}
			if ($charge && isset($charge->payment_method_details->type)) {
				return ucfirst(str_replace('_', ' ', $charge->payment_method_details->type));
			}
		} catch (\Exception $e) {
			log_message('debug', 'Checkout: could not describe payment method for ' . $payment_intent_id . ': ' . $e->getMessage());
		}

		return NULL;
	}
}


class CheckoutException extends RuntimeException {}
