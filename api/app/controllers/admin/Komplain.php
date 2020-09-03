<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Komplain extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('admin/M_Komplain','komplain');
	}

	function index_post()
	{
		$result = $this->komplain->all($this->post());
		$this->response($result);
	}

}

/* End of file Komplain.php */
/* Location: .//F/Server/www/jpstore/api/app/controllers/seller/Komplain.php */