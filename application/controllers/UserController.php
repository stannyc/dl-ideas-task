<?php



class User_Controller extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		if(!$this->current_user){
			$this->session->set_userdata('intended_url', current_url());
			redirect('login');
		}
	}

}

