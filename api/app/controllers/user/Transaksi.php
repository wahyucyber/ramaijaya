<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Transaksi extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('user/M_Transaksi', 'transaksi');
	}

	function snap_token_post()
	{
		$result = $this->transaksi->snap_token($this->post());
		$this->response($result);
	}

	function selesai_post()
	{
		$result = $this->transaksi->selesai($this->post());
		$this->response($result);
	}

}

/* End of file Transaksi.php */
/* Location: ./application/controllers/Transaksi.php */