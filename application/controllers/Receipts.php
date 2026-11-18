<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Receipts extends User_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('receipt_model');
	}	


	public function index()
	{
		$data = $this->receipt_model->paginated($this->current_user->id, array('user_id' => $this->current_user->id));
		$receipts = $data['items'];
		$pagination = $data['pagination'];		
		$this->render('receipts/index', array('title' => 'Receipts', 'receipts' => $receipts, 'pagination' => $pagination));
	}


	
	public function detail($id)
	{
		$receipt = $this->receipt_model->find($id);		
		$this->render('shared/receipt_detail', array('title' => 'Receipt Detail', 'receipt' => $receipt));
	}

}
