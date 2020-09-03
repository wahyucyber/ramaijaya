<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Product_favorit extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('user/M_Product_favorit', 'product_favorit');
	}

	function add_post()
	{
		$result = $this->product_favorit->add($this->post());
		$this->response($result);
	}

}

/* End of file Product_favorit.php */
/* Location: ./application/controllers/Product_favorit.php */