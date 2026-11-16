<?php
defined('BASEPATH') or exit('No direct script access allowed');



class Invoices extends User_Controller
{
	public function index()
	{
		$this->render('invoices/index', array('title' => 'Invoices'));
	}

	public function detail($id)
	{
		$this->render('shared/invoice_detail', array('title' => 'Invoice Detail'));
	}
}
