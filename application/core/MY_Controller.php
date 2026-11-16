<?php





class MY_Controller extends CI_Controller
{

	protected $current_user = null;
	protected $layout = 'user';

	public function __construct()
	{
		parent::__construct();
		$this->load->library('auth');
		$this->current_user = $this->auth->user();
		$this->load->vars(array(
			'current_user' => $this->current_user,
		));
	}

	protected function render($view, $data = array())
	{
		$data['content'] =  $this->load->view($view, $data, TRUE);
		$this->load->view('layouts/' . $this->layout, $data);
	}
}


class User_Controller extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		if (!$this->current_user) {
			$this->session->set_userdata('intended_url', current_url());
			redirect('login');
		}
	}
}


class Admin_Controller extends User_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->layout = 'admin';
		if (!$this->current_user->role == 'admin') {
			show_error('Forbidden', 403);
		}
	}
}


class Api_Controller extends CI_Controller {}
