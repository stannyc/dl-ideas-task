<?php


class Admin_Controller extends User_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		if($this->current_user->role == 'admin'){
			show_error('Forbidden', 403);
		}
	}
}
