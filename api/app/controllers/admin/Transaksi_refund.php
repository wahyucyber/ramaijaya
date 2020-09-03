<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Transaksi_refund extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('admin/M_Transaksi_refund', 'transaksi_refund');
	}

	function index_post()
	{
		$result = $this->transaksi_refund->index($this->post());
		$this->response($result);
	}

	function transfer_post()
	{
		$result = $this->transaksi_refund->transfer($this->post());
		$this->response($result);
	}

}

/* End of file Transaksi_refund.php */
/* Location: ./application/controllers/Transaksi_refund.php */