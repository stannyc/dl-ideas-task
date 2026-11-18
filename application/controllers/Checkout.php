<?php
defined('BASEPATH') or exit('No direct script access allowed');



class Checkout extends User_Controller
{



	public function __construct()
	{
		parent::__construct(); 
		$this->load->model(array('order_model', 'invoice_model', 'receipt_model'));
	}




	public function success()
	{
		$session_id = (string) $this->input->get('session_id');


		if ( ! preg_match('/^cs_[A-Za-z0-9_]+$/', $session_id)) {
			show_404();
		}



		$this->load->library('checkout_service');

		$order = $this->checkout_service->order_for_user_session($this->current_user->id, $session_id);
		if ( ! $order) {
			show_404();
		}


		$notice = NULL;

		if ($order->status !== Order_model::STATUS_PAID) {
			try {
				$order = $this->checkout_service->sync($session_id) ?: $order;
			} catch (CheckoutException $e) {
				log_message('error', 'Checkout success page sync failed for ' . $session_id . ': ' . $e->getMessage());
				$notice = $e->getMessage();
			}
		}


		$invoice = $this->invoice_model->find_by_order($order->id);

		$receipt = $invoice ? $this->receipt_model->find_by_invoice($invoice->id) : NULL;

		$this->render('checkout/success', array(
			'title'   => $this->_title_for($order->status),
			'order'   => $order,
			'items'   => $this->order_model->details($order->id),
			'invoice' => $invoice,
			'receipt' => $receipt,
			'notice'  => $notice,
		));
	}





	public function cancel()
	{
		$this->render('checkout/cancel', array(
			'title' => 'Payment cancelled',
		));
	}

	
	protected function _title_for($status)
	{
		switch ($status) {
			case Order_model::STATUS_PAID:
				return 'Payment successful';
			case Order_model::STATUS_PENDING:
				return 'Payment processing';
			default:
				return 'Payment not completed';
		}
	}
}
