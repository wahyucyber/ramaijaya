<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Shop extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_Shop','shop');
	}

	function index_post()
	{
		$result = $this->shop->get($this->post());
		return $this->response($result);
	}

	function cek_post()
	{
		$result = $this->shop->cek($this->post());
		return $this->response($result);
	}

	function open_post()
	{
		$result = $this->shop->open($this->post());
		return $this->response($result);
	}	

	function detail_post()
	{
		$result = $this->shop->detail($this->post());
		return $this->response($result);
	}

	function product_post()
	{
		$result = $this->shop->product($this->post());
		return $this->response($result);
	}

	function category_product_post()
	{
		$result = $this->shop->category_product($this->post());
		return $this->response($result);
	}
	
	function ulasan_post()
	{
		$result = $this->shop->ulasan($this->post());
		return $this->response($result);
	}

}

/* End of file Shop.php */
/* Location: .//F/xampp/htdocs/com/JPStore/api/base/controllers/Shop.php */