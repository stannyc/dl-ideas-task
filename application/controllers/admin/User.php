<?php
defined('BASEPATH') OR exit('No direct script access allowed');



class User extends Admin_Controller
{
	public function index()
	{
		$this->render('admin/users/index', array('title' => 'User List'));
	}


	public function form($id = null)
	{
		$title = !!$id ? 'Edit User' : 'Create User';
		$this->render('admin/users/form', array('title' => $title));
	}

}






