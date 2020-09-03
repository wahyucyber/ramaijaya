<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Provinsi extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_Provinsi','provinsi');
	}

	function index_post()
	{
		$result = $this->provinsi->all($this->post());
		return $this->response($result);
	}

}

/* End of file provinsi.php */
/* Location: .//F/xampp/htdocs/com/JPStore/api/base/controllers/provinsi.php */