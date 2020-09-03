<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pembelian extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('user/M_Pembelian', 'pembelian');
	}

	function index_post()
	{
		$result = $this->pembelian->index($this->post());
		$this->response($result);
	}

	function tagihan_post()
	{
		$result = $this->pembelian->tagihan($this->post());
		$this->response($result);
	}

	function detail_post()
	{
		$result = $this->pembelian->detail($this->post());
		$this->response($result);
	}

	function transaksi_detail_post()
	{
		$result = $this->pembelian->transaksi_detail($this->post());
		$this->response($result);
	}

	function upload_pembayaran_post()
	{
		$result = $this->pembelian->upload_pembayaran($this->post());
		$this->response($result);
	}

	function payment_manual_post()
	{
		$result = $this->pembelian->payment_manual($this->post());
		$this->response($result);
	}

	function ulasan_add_post()
	{
		$result = $this->pembelian->ulasan_add($this->post());
		$this->response($result);
	}
	
	function komplain_add_post()
	{
		$result = $this->pembelian->komplain_add($this->post());
		$this->response($result);
	}

	function ulasan_post()
	{
		$result = $this->pembelian->ulasan($this->post());
		$this->response($result);
	}

	function terima_post()
	{
		$result = $this->pembelian->terima($this->post());
		$this->response($result);
	}

	function set_kurir_post()
	{
		$result = $this->pembelian->set_kurir($this->post());
		$this->response($result);
	}

	function cetak_post()
	{
		$result = $this->pembelian->cetak($this->post());
		$this->response($result);
	}
	
	function batalkan_post()
	{
		$result = $this->pembelian->batal_pembelian($this->post());
		$this->response($result);
	}
	
	function hapus_post()
	{
		$result = $this->pembelian->hapus_pembelian($this->post());
		$this->response($result);
	}
	
	

}

/* End of file Pembelian.php */
/* Location: ./application/controllers/Pembelian.php */