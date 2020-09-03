<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Shop extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('seller/M_Shop','shop');
	}

	function index_post()
	{
		$result = $this->shop->get($this->post());
		return $this->response($result);
	}

	function edit_post()
	{
		$result = $this->shop->edit($this->post());
		return $this->response($result);
	}

	function upload_logo_post()
	{
		$result = $this->shop->upload_logo($this->post());
		$this->response($result);
	}

	function upload_banner_post()
	{
		$result = $this->shop->upload_banner($this->post());
		$this->response($result);
	}

}

/* End of file Shop.php */
/* Location: .//F/xampp/htdocs/com/JPStore/api/base/controllers/seller/Shop.php */