<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cart extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_Cart', 'cart');
	}

	function add_post()
	{
		$result = $this->cart->add($this->post());
		$this->response($result);
	}

	function list_post()
	{
		$result = $this->cart->list($this->post());
		$this->response($result);
	}

	function detail_post()
	{
		$result = $this->cart->detail($this->post());
		$this->response($result);
	}

	function delete_post()
	{
		$result = $this->cart->delete($this->post());
		$this->response($result);
	}

	function set_qty_post()
	{
		$result = $this->cart->set_qty($this->post());
		$this->response($result);
	}

	function set_checked_post()
	{
		$result = $this->cart->set_checked($this->post());
		$this->response($result);
	}

	function checkout_post()
	{
		$result = $this->cart->checkout($this->post());
		$this->response($result);
	}

	function checkout_kurir_post()
	{
		$result = $this->cart->checkout_kurir($this->post());
		$this->response($result);
	}
	
	function set_catatan_post()
	{
		$result = $this->cart->set_catatan($this->post());
		$this->response($result);
	}

}

/* End of file Cart.php */
/* Location: ./application/controllers/Cart.php */