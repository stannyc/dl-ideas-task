<?php
defined('BASEPATH') or exit('No direct script access allowed');



class Invoices extends User_Controller
{
	public function index()
	{
		$this->render('invoices/index', array('title' => 'Invoices'));
	}
}
