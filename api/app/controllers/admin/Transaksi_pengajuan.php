<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Transaksi_pengajuan extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('admin/M_Transaksi_pengajuan', 'transaksi_pengajuan');
	}

	function index_post()
	{
		$result = $this->transaksi_pengajuan->index($this->post());
		$this->response($result);
	}

	function transfer_post()
	{
		$result = $this->transaksi_pengajuan->transfer($this->post());
		$this->response($result);
	}

}

/* End of file Transaksi_pengajuan.php */
/* Location: ./application/controllers/Transaksi_pengajuan.php */