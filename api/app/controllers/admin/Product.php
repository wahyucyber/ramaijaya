<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Product extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('admin/M_Product', 'product');
	}

	function index_post()
	{
		$result = $this->product->index($this->post());
		$this->response($result);
	}

	function set_verifikasi_post()
	{
		$result = $this->product->set_verifikasi($this->post());
		$this->response($result);
	}

	function set_nonverifikasi_post()
	{
		$result = $this->product->set_nonverifikasi($this->post());
		$this->response($result);
	}

}

/* End of file Product.php */
/* Location: ./application/controllers/Product.php */