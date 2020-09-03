<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_Product','product');
	}

	function index_post()
	{
		$result = $this->product->all($this->post());
		return $this->response($result);
	}

	function list_post()
	{
		$result = $this->product->list($this->post());
		return $this->response($result);
	}

	function detail_post()
	{
		$result = $this->product->detail($this->post());
		$this->response($result);
	}

	function search_post()
	{
		$result = $this->product->search($this->post());
		$this->response($result);
	}

	function ulasan_post()
	{
		$result = $this->product->ulasan($this->post());
		$this->response($result);
	}

	function other_product_post()
	{
		$result = $this->product->other_product($this->post());
		$this->response($result);
	}
	
	function produk_diskon_post()
	{
		$result = $this->product->produk_diskon($this->post());
		$this->response($result);
	}

}

/* End of file Product.php */
/* Location: .//F/xampp/htdocs/com/JPStore/api/base/controllers/Product.php */