<?php


class Authentication extends CI_Controller
{

	public function login_form()
	{
		$this->load->view('auth/login');
	}


	public function attempt()
	{
		$this->load->library('form_validation');

		$this->load->model('user_model');

		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');

		$this->form_validation->set_rules('password', 'Password', 'required');

		if ($this->form_validation->run() === FALSE) {
			return $this->login_form();
		}

		$email    = strtolower($this->input->post('email'));
		$password = $this->input->post('password');

		$user = $this->user_model->find_active_by_email($email);

		if (! $user || ! password_verify($password, $user->password_hash)) {

			$this->session->set_flashdata('error', 'Invalid email or password.');
			$this->session->set_flashdata('old_email', $email);
			redirect('login');
			
		}

		$this->session->sess_regenerate(TRUE);

		$this->session->set_userdata('user_id', (int) $user->id);

		$intended = $this->session->userdata('intended_url');

		$this->session->unset_userdata('intended_url');


		if ($intended) {
			redirect($intended);
		}

		redirect($user->role === 'admin' ? 'admin' : 'home');
	}


	public function logout()
	{
	
		if ($this->input->method() !== 'post') {
			show_error('Method Not Allowed', 405);
		}

		$this->session->unset_userdata(array('user_id', 'intended_url'));
		$this->session->sess_destroy();

		redirect('/');
	}
}
