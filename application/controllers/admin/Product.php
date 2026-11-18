<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Product extends Admin_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('product_model');
	}


	public function index()
	{
		$data = $this->product_model->paginate([], 12);
		$products = $data['items'];
		$pagination = $data['pagination'];
		$this->render('admin/products/index', array('title' => 'Product List', 'products' => $products, 'pagination' => $pagination));
	}


	public function form($id = null)
	{

		$product = NULL;
		if ($id) {
			$product = $this->product_model->find($id);
		}

		$this->_render_form($product);
	}



	public function _render_form($product = NULL, $error = NULL)
	{
		$this->render('admin/products/form', array(
			'title'  => $product ? 'Edit Product' : 'New Product',
			'product'   => $product,
			'action' => $product ? 'admin/product/save/' . $product->id : 'admin/product/save',
			'error'  => $error,
		));
	}



	public function save($id = NULL)
	{
		if ($this->input->method() !== 'post') {
			show_error('Method Not Allowed', 405);
		}

		$is_edit = ($id !== NULL);
		$product    = NULL;

		if ($is_edit) {
			$product = $this->product_model->find($id);
			if (! $product) {
				show_404();
			}
		}


		$this->load->library('form_validation');

		$this->form_validation->set_rules('name', 'Name', 'trim|required|max_length[150]');
		$this->form_validation->set_rules('price', 'Price', 'trim|required');


		if ($this->form_validation->run() === FALSE) {
			return $this->_render_form($product);
		}

		$data = array(
			'name'      => $this->input->post('name'),
			'description'     => $this->input->post('description'),
			'price'      => (float) $this->input->post('price') * 100,
			'is_active' => 1, //$this->input->post('is_active') ? 1 : 0,			
		);


		$newImage = $this->_upload_product_image();
		if ($newImage === FALSE) {
			return $this->_render_form($product, $this->upload->display_errors('', ''));
		}

		if ($newImage !== NULL) {
			$data['image'] = $newImage;
		}

		if ($is_edit) {
			$ok = $this->product_model->update($id, $data);
		} else {
			$ok = (bool) $this->product_model->create($data);
		}


		if (! $ok) {
			if ($newImage) {
				@unlink(FCPATH . 'uploads/products/' . $newImage); //del/rollback recently uploaded avatar
			}
			return $this->_render_form($product, 'Could not save the user. Please try again.');
		}

		if ($is_edit && $newImage && ! empty($product->image)) {
			@unlink(FCPATH . 'uploads/products/' . $product->image); //del old avatar
		}

		$this->session->set_flashdata('success', $is_edit ? 'Product updated.' : 'Product created.');
		redirect('admin/product');
	}



	protected function _upload_product_image()
	{
		if (empty($_FILES['image']) || $_FILES['image']['error'] === UPLOAD_ERR_NO_FILE) {
			return NULL;
		}

		$this->load->library('upload', array(
			'upload_path'      => FCPATH . 'uploads/products/',
			'allowed_types'    => 'jpg|jpeg|png|webp',
			'max_size'         => 1024,   // KB
			'encrypt_name'     => TRUE,
			'file_ext_tolower' => TRUE,
		));

		if (! $this->upload->do_upload('image')) {
			return FALSE;
		}

		return $this->upload->data('file_name');
	}

	public function toggle_active($id = NULL)
	{
		if ($this->input->method() !== 'post') {
			show_error('Method Not Allowed', 405);
		}

		$product = $this->product_model->find($id);
		if (! $product) {
			show_404();
		}

		$activate = ! (bool) $product->is_active;   // flip the state in db

		if ($this->product_model->set_active($product->id, $activate)) {
			$this->session->set_flashdata('success', 'Product '.html_escape($product->name) . ($activate ? ' is now available in the shop.' : ' has been hidden from the shop.'));
		} else {
			$this->session->set_flashdata('error', 'Could not update the product.');
		}

		redirect('admin/product');
	}
}
