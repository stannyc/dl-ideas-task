<?php

class Auth
{

	protected $CI;
	protected $user = FALSE;

	public function __construct()
	{
		$this->CI =& get_instance();
	}

	public function user()
	{
		if($this->user === FALSE){
			$id = $this->CI->session->userdata('user_id');
			$this->user = $id ? $this->CI->db->get_where('users', array('id' => $id, 'is_active' => 1))->row() : NULL;
		}
		return $this->user;
	}

	public function is_admin()
	{
		return $this->user() && $this->user()->role === 'admin';
	}

}

