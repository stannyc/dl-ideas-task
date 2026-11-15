<?php
defined('BASEPATH') OR exit('No direct script access allowed');



class Product extends Admin_Controller
{
	public function index()
	{
		$this->render('admin/products/index', array('title' => 'Product List'));
	}


	public function form($id = null)
	{
		$title = !!$id ? 'Edit Product' : 'Create Product';
		$this->render('admin/products/form', array('title' => $title));
	}



}



