<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('seller/M_Product','product');
	}

	function index_post()
	{
		$result = $this->product->all($this->post());
		return $this->response($result);
	}

	function get_post()
	{
		$result = $this->product->get($this->post());
		return $this->response($result);
	}

	function add_post()
	{
		$result = $this->product->add($this->post());
		return $this->response($result);
	}

	function edit_post()
	{
		$result = $this->product->edit($this->post());
		return $this->response($result);
	}

	function set_status_post()
	{
		$result = $this->product->set_status($this->post());
		return $this->response($result);
	}

	function delete_post()
	{
		$result = $this->product->delete($this->post());
		return $this->response($result);
	}

	function import_post()
	{
		$result = $this->product->import($this->post());
		$this->response($result);
	}

}

/* End of file Product.php */
/* Location: .//F/xampp/htdocs/com/JPStore/api/base/controllers/seller/Product.php */