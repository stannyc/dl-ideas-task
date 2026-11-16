<?php
defined('BASEPATH') or exit('No direct script access allowed');



class Home extends User_Controller
{
	public function index()
	{
		$this->render('shop/index', array('title' => 'Shop'));
	}
}
