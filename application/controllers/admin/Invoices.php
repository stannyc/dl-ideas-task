<?php
defined('BASEPATH') OR exit('No direct script access allowed');



class Invoices extends Admin_Controller
{
	public function index()
	{

		$this->render('admin/invoices/index', array('title' => 'Invoices', 'base_uri' => 'admin/invoices'));
	}


	public function detail($id)
	{
		$this->render('shared/invoice_detail', array('title' => 'Invoice Detail'));
	}

}
