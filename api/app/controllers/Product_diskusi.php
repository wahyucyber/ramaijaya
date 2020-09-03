<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Product_diskusi extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_Product_diskusi', 'product_diskusi');
	}

	function index_post()
	{
		$result = $this->product_diskusi->all($this->post());
		$this->response($result);
	}

	function add_post()
	{
		$result = $this->product_diskusi->add($this->post());
		$this->response($result);
	}
	
	function balas_post()
	{
		$result = $this->product_diskusi->balas($this->post());
		$this->response($result);
	}

}

/* End of file Product_diskusi.php */
/* Location: ./application/controllers/Product_diskusi.php */