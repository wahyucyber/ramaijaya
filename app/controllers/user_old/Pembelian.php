<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pembelian extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$data['title'] = 'Pembelian';
        $params['view'] = 'user/pesanan';
        $params['js'] = 'user/pesanan';
        $params['modal'] = 'user/pembelian';

        $this->load_view($params,$data);
	}

	public function detail($no_invoice = null)
	{
		if ($no_invoice == null) {
			header('location: '.base_url('404'));
		}

		$data['no_invoice'] = $no_invoice;

		$data['title'] = 'Pembelian';
        $params['view'] = 'user/pembelian_detail';
        $params['js'] = 'user/pembelian_detail';

        $this->load_view($params,$data);
	}

	public function cetak($no_invoice = null)
	{
		if ($no_invoice == null) {
			header('location: '.base_url('404'));
		}

		$data['no_invoice'] = $no_invoice;

		$data['title'] = 'Cetak Pembelian';
        $params['view'] = 'user/cetak_pembelian';
        $params['js'] = 'user/cetak_pembelian';

        $this->load_view($params,$data);
	}

	public function print($no_invoice = null)
	{
		if ($no_invoice == null) {
			header('location: '.base_url('404'));
		}

		$data['no_invoice'] = $no_invoice;

		$this->load->view('user/cetak_pembelian_print', $data);
	}

}

/* End of file Pembelian.php */
/* Location: ./application/controllers/Pembelian.php */