<?php
defined('BASEPATH') or exit('No direct script access allowed');



class Home extends User_Controller
{
	public function index()
	{
		$this->load->model('product_model');

		$data = $this->product_model->paginate(array('is_active' => 1), 12);

		$products = $data['items'];
		
		$pagination = $data['pagination'];		
		$this->render('shop/index', array('title' => 'Shop','products' => $products, 'pagination' => $pagination));
	}
}
