<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Get_urlmeta extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index_post()
	{
		$result = $this->Func->get_urlmeta($this->post());
		$this->response($result);
	}

}

/* End of file Get_urlmeta.php */
/* Location: .//F/Server/www/jpstore/api/app/controllers/Get_urlmeta.php */