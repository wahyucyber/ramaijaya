<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GetToken extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_Api','api');
	}

	function index_post()
	{
		$result = $this->api->get_token($this->post());
		return $this->response($result);
	}

}

/* End of file GetToken.php */
/* Location: .//F/xampp/htdocs/com/JPStore/api/base/controllers/GetToken.php */