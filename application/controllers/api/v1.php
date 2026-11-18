<?php
defined('BASEPATH') or exit('No direct script access allowed');


class V1 extends CI_Controller
{
	const TOKEN_LIFETIME_DAYS = 30;

	
	protected $endpoints = array(
		'login'    => array('post', FALSE),
		'logout'   => array('post', TRUE),
		'me'       => array('get',  TRUE),
		'invoices' => array('get',  TRUE),
		'receipts' => array('get',  TRUE),
	);
	
	protected $api_user = NULL;

	protected $api_token_id = NULL;

	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('user_model', 'invoice_model', 'receipt_model'));
	}


	public function _remap($method, $params = array())
	{
		if ( ! isset($this->endpoints[$method])) {
			return $this->_error(404, 'not_found', 'Unknown endpoint.');
		}

		list($verb, $needs_token) = $this->endpoints[$method];

		if ($this->input->method() !== $verb) {
			$this->output->set_header('Allow: ' . strtoupper($verb));
			return $this->_error(405, 'method_not_allowed', 'Use ' . strtoupper($verb) . ' for this endpoint.');
		}

		if ($needs_token && ! $this->_authenticate()) {
			$this->output->set_header('WWW-Authenticate: Bearer');
			return $this->_error(401, 'unauthenticated', 'Missing, invalid or expired token.');
		}

		return call_user_func_array(array($this, $method), $params);
	}


	//auth
	public function login()
	{
		$body     = $this->_body();
		$email    = isset($body['email']) ? trim((string) $body['email']) : '';
		$password = isset($body['password']) ? (string) $body['password'] : '';
		$device   = isset($body['device_name']) ? mb_substr(trim((string) $body['device_name']), 0, 100) : NULL;

		if ($email === '' || $password === '') {
			return $this->_error(422, 'validation_failed', 'Email and password are required.');
		}

		$user = $this->user_model->find_active_by_email($email);

		if ( ! $user || ! password_verify($password, $user->password_hash)) {
			return $this->_error(401, 'invalid_credentials', 'Invalid email or password.');
		}

		// The plain token is returned once and never stored; only its SHA-256 hash is saved
		$token      = bin2hex(random_bytes(32));
		$expires_at = gmdate('Y-m-d H:i:s', time() + self::TOKEN_LIFETIME_DAYS * 86400);

		$this->db->insert('api_tokens', array(
			'user_id'    => (int) $user->id,
			'token_hash' => hash('sha256', $token),
			'name'       => $device ?: NULL,
			'expires_at' => $expires_at,
		));

		return $this->_json(201, array(
			'data' => array(
				'token'      => $token,
				'token_type' => 'Bearer',
				'expires_at' => $this->_iso($expires_at),
				'user'       => $this->_user_resource($user),
			),
		));
	}


	public function logout()
	{
		$this->db->set('revoked_at', 'UTC_TIMESTAMP()', FALSE)
			->where('id', $this->api_token_id)
			->update('api_tokens');

		return $this->_json(200, array('data' => array('message' => 'Signed out.')));
	}


	public function me()
	{
		return $this->_json(200, array('data' => $this->_user_resource($this->api_user)));
	}


	//invoice
	public function invoices($id = NULL)
	{
		if ($id !== NULL) {
			if ( ! ctype_digit((string) $id)) {
				return $this->_error(404, 'not_found', 'Invoice not found.');
			}

			$invoice = $this->invoice_model->find_for_user((int) $id, $this->api_user->id);
			if ( ! $invoice) {
				return $this->_error(404, 'not_found', 'Invoice not found.');
			}

			return $this->_json(200, array('data' => $this->_invoice_resource($invoice, TRUE)));
		}

		$result = $this->invoice_model->paginate_for_user(
			$this->api_user->id,
			array(
				'search' => $this->input->get('search', TRUE),
				'status' => $this->input->get('status', TRUE),
			),
			$this->_per_page(),
			$this->input->get('page')
		);

		$data = array();
		foreach ($result['items'] as $invoice) {
			$data[] = $this->_invoice_resource($invoice, FALSE);
		}

		return $this->_json(200, array('data' => $data, 'meta' => $result['pagination']));
	}


	//receipt
	public function receipts($id = NULL)
	{
		if ($id !== NULL) {
			if ( ! ctype_digit((string) $id)) {
				return $this->_error(404, 'not_found', 'Receipt not found.');
			}

			$receipt = $this->_find_receipt_for_user((int) $id, $this->api_user->id);
			if ( ! $receipt) {
				return $this->_error(404, 'not_found', 'Receipt not found.');
			}

			return $this->_json(200, array('data' => $this->_receipt_resource($receipt, TRUE)));
		}

		$result = $this->receipt_model->paginate_for_user(
			$this->api_user->id,
			array('search' => $this->input->get('search', TRUE)),
			$this->_per_page(),
			$this->input->get('page')
		);

		$data = array();
		foreach ($result['items'] as $receipt) {
			$data[] = $this->_receipt_resource($receipt, FALSE);
		}

		return $this->_json(200, array('data' => $data, 'meta' => $result['pagination']));
	}


	//
	protected function _authenticate()
	{
		$token = $this->_bearer_token();
		if ($token === NULL) {
			return FALSE;
		}

		$row = $this->db
			->select('t.id AS token_id, t.user_id')
			->from('api_tokens t')
			->join('users u', 'u.id = t.user_id')
			->where('t.token_hash', hash('sha256', $token))
			->where('t.revoked_at IS NULL', NULL, FALSE)
			->where('t.expires_at > UTC_TIMESTAMP()', NULL, FALSE)
			->where('u.is_active', 1)
			->limit(1)
			->get()
			->row();

		if ( ! $row) {
			return FALSE;
		}

		$user = $this->user_model->find_active($row->user_id);
		if ( ! $user) {
			return FALSE;
		}

		$this->api_user     = $user;
		$this->api_token_id = (int) $row->token_id;

		$this->db->set('last_used_at', 'UTC_TIMESTAMP()', FALSE)
			->where('id', $this->api_token_id)
			->update('api_tokens');

		return TRUE;
	}



	protected function _bearer_token()
	{
		$header = $this->input->get_request_header('Authorization', TRUE);

		if ( ! $header) {
			foreach (array('HTTP_AUTHORIZATION', 'REDIRECT_HTTP_AUTHORIZATION') as $key) {
				if ( ! empty($_SERVER[$key])) {
					$header = $_SERVER[$key];
					break;
				}
			}
		}

		if ($header && preg_match('/^Bearer\s+([a-f0-9]{64})$/i', trim($header), $m)) {
			return strtolower($m[1]);
		}

		return NULL;
	}


	



	protected function _find_receipt_for_user($id, $user_id)
	{
		$receipt = $this->db
			->select('r.id, r.receipt_number, r.invoice_id, r.amount_paid, r.currency, r.payment_method, r.paid_at,
			          i.invoice_number, i.order_id')
			->from('receipts r')
			->join('invoices i', 'i.id = r.invoice_id')
			->join('orders o', 'o.id = i.order_id')
			->where('r.id', $id)
			->where('o.user_id', (int) $user_id)
			->limit(1)
			->get()
			->row();

		if ( ! $receipt) {
			return NULL;
		}

		$invoice        = $this->invoice_model->find_for_user($receipt->invoice_id, $user_id);
		$receipt->items = ($invoice && isset($invoice->items)) ? $invoice->items : array();

		return $receipt;
	}





	protected function _user_resource($user)
	{
		return array(
			'id'    => (int) $user->id,
			'name'  => $user->name,
			'email' => $user->email,
			'role'  => $user->role,
		);
	}





	protected function _invoice_resource($invoice, $with_items)
	{
		$data = array(
			'id'             => (int) $invoice->id,
			'invoice_number' => $invoice->invoice_number,
			'order_id'       => (int) $invoice->order_id,
			'status'         => $invoice->status,
			'amount'         => (int) $invoice->amount,   // smallest currency unit (cents)
			'currency'       => $invoice->currency,
			'issued_at'      => $this->_iso($invoice->issued_at),
			'paid_at'        => $this->_iso($invoice->paid_at),
		);

		if ($with_items) {
			$data['items'] = $this->_items_resource(isset($invoice->items) ? $invoice->items : array());
		}

		return $data;
	}




	protected function _receipt_resource($receipt, $with_items)
	{
		$data = array(
			'id'             => (int) $receipt->id,
			'receipt_number' => $receipt->receipt_number,
			'invoice_id'     => (int) $receipt->invoice_id,
			'invoice_number' => $receipt->invoice_number,
			'order_id'       => (int) $receipt->order_id,
			'amount_paid'    => (int) $receipt->amount_paid,   // cents
			'currency'       => $receipt->currency,
			'payment_method' => $receipt->payment_method,
			'paid_at'        => $this->_iso($receipt->paid_at),
		);

		if ($with_items) {
			$data['items'] = $this->_items_resource($receipt->items);
		}

		return $data;
	}





	protected function _items_resource(array $items)
	{
		$data = array();
		foreach ($items as $item) {
			$data[] = array(
				'product_id'   => (int) $item->product_id,
				'product_name' => $item->product_name,
				'unit_price'   => (int) $item->unit_price,   // cents
				'quantity'     => (int) $item->quantity,
				'line_total'   => (int) $item->line_total,   // cents
			);
		}
		return $data;
	}





	protected function _body()
	{
		$raw = $this->input->raw_input_stream;

		if ($raw !== '' && $raw !== NULL) {
			$json = json_decode($raw, TRUE);
			if (is_array($json)) {
				return $json;
			}
		}

		return (array) $this->input->post();
	}

	protected function _per_page()
	{
		$per_page = (int) $this->input->get('per_page');
		return ($per_page >= 1 && $per_page <= 100) ? $per_page : 15;
	}


	

	protected function _iso($datetime)
	{
		if (empty($datetime)) {
			return NULL;
		}
		return gmdate('Y-m-d\TH:i:s\Z', strtotime($datetime . ' UTC'));
	}

	protected function _json($status, array $payload)
	{
		$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_header('Cache-Control: no-store')
			->set_output(json_encode($payload, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
	}


	protected function _error($status, $code, $message)
	{
		$this->_json($status, array(
			'error' => array(
				'code'    => $code,
				'message' => $message,
			),
		));
	}













	
}
