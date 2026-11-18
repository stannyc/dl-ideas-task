<?php
defined('BASEPATH') OR exit('No direct script access allowed');



class Invoices extends Admin_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('invoice_model');
	}

	public function index()
	{		
		$querydata = $this->invoice_model->paginated();
		$invoices = $querydata['items'];
		$pagination = $querydata['pagination'];
		$this->render('admin/invoices/index', array('title' => 'Invoices', 'invoices' => $invoices, 'pagination' => $pagination));
	}


	public function detail($id)
	{
		$this->load->model('order_model');
		$invoice = $this->invoice_model->find($id);
		$items = $this->order_model->details($invoice->order_id);
		$this->render('shared/invoice_detail', array('title' => 'Invoice Detail', 'invoice' => $invoice, 'items' => $items));
	}

}
