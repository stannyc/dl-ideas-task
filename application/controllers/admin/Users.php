<?php
defined('BASEPATH') or exit('No direct script access allowed');



class Users extends Admin_Controller
{


	public function __construct()
	{
		parent::__construct();
		$this->load->model('user_model');
	}

	public function index()
	{
		$users = $this->user_model->paginate();
		$this->render('admin/users/index', array('title' => 'User List', 'users' => $users));
	}


	public function form($id = null)
	{
		$user = NULL;
		if ($id) {
			$user = $this->user_model->find($id);
		}
		$this->_render_form($user);
	}


	public function save($id = NULL)
	{
		if ($this->input->method() !== 'post') {
			show_error('Method Not Allowed', 405);
		}

		$is_edit = ($id !== NULL);
		$user    = NULL;

		if ($is_edit) {
			$user = $this->user_model->find($id);
			if (! $user) {
				show_404();
			}
		}


		$this->load->library('form_validation');

		$this->form_validation->set_rules('name', 'Name', 'trim|required|max_length[150]');
		$this->form_validation->set_rules(
			'email',
			'Email',
			'trim|required|valid_email|max_length[100]|callback__unique_email[' . ($is_edit ? (int) $id : 0) . ']'
		);
		$this->form_validation->set_rules('role', 'Role', 'required|in_list[admin,user]');


		$password_rules = 'min_length[8]|max_length[72]';
		if (! $is_edit) {
			$password_rules = 'required|' . $password_rules;
		}
		$this->form_validation->set_rules('password', 'Password', $password_rules);
		$this->form_validation->set_rules('password_confirm', 'Password confirmation', 'matches[password]');

		if ($this->form_validation->run() === FALSE) {
			return $this->_render_form($user);   // re-show form with errors + old input
		}


		$data = array(
			'name'      => $this->input->post('name'),
			'email'     => $this->input->post('email'),
			'role'      => $this->input->post('role'),
			'is_active' => $this->input->post('is_active') ? 1 : 0,
			'password'  => $this->input->post('password'),
		);

		
		if ($is_edit && (int) $id === (int) $this->current_user->id) {
			$data['role']      = User_model::ROLE_ADMIN;
			$data['is_active'] = 1;
		}

		
		$new_avatar = $this->_upload_avatar();
		if ($new_avatar === FALSE) {
			return $this->_render_form($user, $this->upload->display_errors('', ''));
		}
		if ($new_avatar !== NULL) {
			$data['avatar'] = $new_avatar;
		}

		
		if ($is_edit) {
			$ok = $this->user_model->update($id, $data);
		} else {
			$ok = (bool) $this->user_model->create($data);
		}

		if (! $ok) {
			if ($new_avatar) {
				@unlink(FCPATH . 'uploads/avatars/' . $new_avatar); //del/rollback recently uploaded avatar
			}
			return $this->_render_form($user, 'Could not save the user. Please try again.');
		}
		
		if ($is_edit && $new_avatar && ! empty($user->avatar)) {
			@unlink(FCPATH . 'uploads/avatars/' . $user->avatar); //del old avatar
		}

		$this->session->set_flashdata('success', $is_edit ? 'User updated.' : 'User created.');
		redirect('admin/users');
	}


	public function toggle_active($id = NULL)
	{
		if ($this->input->method() !== 'post') {
			show_error('Method Not Allowed', 405);
		}

		$user = $this->user_model->find($id);
		if (! $user) {
			show_404();
		}

		if ((int) $user->id === (int) $this->current_user->id) {
			$this->session->set_flashdata('error', "You can't deactivate your own account.");
			redirect('admin/users');
		}

		$activate = ! (bool) $user->is_active;   // flip the current state
		$this->user_model->set_active($user->id, $activate);

		$this->session->set_flashdata('success', html_escape($user->name) . ($activate ? ' has been activated.' : ' has been deactivated.'));
		redirect('admin/users');
	}


	protected function _render_form($user = NULL, $error = NULL)
	{
		$this->render('admin/users/form', array(
			'title'  => $user ? 'Edit user' : 'New user',
			'user'   => $user,
			'action' => $user ? 'admin/users/save/' . $user->id : 'admin/users/save',
			'error'  => $error,
		));
	}

	public function _unique_email($email, $except_id)
	{
		$except_id = (int) $except_id ?: NULL;

		if ($this->user_model->email_exists($email, $except_id)) {
			$this->form_validation->set_message('_unique_email', 'This {field} is already registered.');
			return FALSE;
		}

		return TRUE;
	}


	protected function _upload_avatar()
	{
		if (empty($_FILES['avatar']) || $_FILES['avatar']['error'] === UPLOAD_ERR_NO_FILE) {
			return NULL;
		}

		$this->load->library('upload', array(
			'upload_path'      => FCPATH . 'uploads/avatars/',
			'allowed_types'    => 'jpg|jpeg|png|webp',
			'max_size'         => 1024,   // KB
			'encrypt_name'     => TRUE,
			'file_ext_tolower' => TRUE,
		));

		if (! $this->upload->do_upload('avatar')) {
			return FALSE;
		}

		return $this->upload->data('file_name');
	}
}
