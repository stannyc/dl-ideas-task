<?php
defined('BASEPATH') OR exit('No direct script access allowed');



class Receipts extends Admin_Controller
{
	public function index()
	{
		$this->render('admin/receipts/index', array('title' => 'Receipts'));
	}

}
