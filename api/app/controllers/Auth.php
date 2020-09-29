<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_Auth','auth');
	}

	public function google_post()
	{
		$result = $this->auth->loginWithGoogle($this->post());

		$this->response($result);
	}

	function login_post()
	{
		$result = $this->auth->login($this->post());
		$this->response($result);
	}

	function register_post()
	{
		$result = $this->auth->register($this->post());
		$this->response($result);
	}

}

/* End of file Auth.php */
/* Location: .//F/xampp/htdocs/com/JPStore/api/base/controllers/Auth.php */