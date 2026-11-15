<?php
defined('BASEPATH') or exit('No direct script access allowed');



class Receipts extends User_Controller
{
	public function index()
	{
		$this->render('receipts/index', array('title' => 'Receipts'));
	}
}
