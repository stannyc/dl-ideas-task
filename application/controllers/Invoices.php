<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Invoices extends User_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('invoice_model');
	}



	public function index()
	{
		$querydata = $this->invoice_model->paginated(array('user_id' => $this->current_user->id), $this->current_user->id);
		$invoices = $querydata['items'];
		$pagination = $querydata['pagination'];		
		$this->render('invoices/index', array('title' => 'Invoices', 'invoices' => $invoices, 'pagination' => $pagination));
	}

	public function detail($id)
	{
		$this->load->model('order_model');
		$invoice = $this->invoice_model->find($id);
		$items = $this->order_model->details($invoice->order_id);
		$this->render('shared/invoice_detail', array('title' => 'Invoice Detail', 'invoice' => $invoice, 'items' => $items));
	}
}
