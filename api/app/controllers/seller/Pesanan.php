<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pesanan extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('seller/M_Pesanan', 'pesanan');
	}

	function index_post()
	{
		$result = $this->pesanan->index($this->post());
		$this->response($result);
	}

	function detail_post()
	{
		$result = $this->pesanan->detail($this->post());
		$this->response($result);
	}

	function proses_post()
	{
		$result = $this->pesanan->proses($this->post());
		$this->response($result);
	}

	function kirim_post()
	{
		$result = $this->pesanan->kirim($this->post());
		$this->response($result);
	}

	public function cetak_post()
	{
		$result = $this->pesanan->cetak($this->post());
		$this->response($result);
	}

}

/* End of file Pesanan.php */
/* Location: ./application/controllers/Pesanan.php */