<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Forgot extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_Auth','user');
	}

	function send_post()
	{
		$result = $this->user->send_forgot($this->post());
		$this->response($result);
	}
	
	function reset_password_post()
	{
	    $result = $this->user->reset_password($this->post());
		$this->response($result);
	}

}

/* End of file Forgot.php */
/* Location: .//F/Server/www/jpstore/api/app/controllers/Forgot.php */