<?php
defined('BASEPATH') or exit('No direct script access allowed');



class Receipts extends Admin_Controller
{
	public function index()
	{
		$this->render('admin/receipts/index', array('title' => 'Receipts'));
	}

	public function detail($id)
	{
		$this->render('shared/receipt_detail', array('title' => 'Receipt Detail'));
	}
}
