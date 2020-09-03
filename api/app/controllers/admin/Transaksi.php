<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Transaksi extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('admin/M_Transaksi', 'transaksi');
	}

	function index_post()
	{
		$result = $this->transaksi->index($this->post());
		$this->response($result);
	}

	function verifikasi_pembayaran_post()
	{
		$result = $this->transaksi->verifikasi_pembayaran($this->post());
		$this->response($result);
	}

	function detail_post()
	{
		$result = $this->transaksi->detail($this->post());
		$this->response($result);
	}

	public function cetak_post()
	{
		$result = $this->transaksi->cetak($this->post());
		$this->response($result);
	}

}

/* End of file Transaksi.php */
/* Location: ./application/controllers/Transaksi.php */