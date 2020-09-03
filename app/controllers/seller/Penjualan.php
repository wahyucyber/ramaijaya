<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penjualan extends MY_Seller {

	public function index()
	{
		$data['title'] = 'Pesanan';
        $params['view'] = 'seller/penjualan';
        $params['js'] = 'seller/penjualan';

        $this->load_view($params,$data);
	}

	public function detail($no_transaksi = null)
	{
		if ($no_transaksi == null) {
			header('location: '.base_url('404'));
		}
		
		$data['no_transaksi'] = $no_transaksi;
		$data['title'] = 'Pesanan';
        $params['view'] = 'seller/penjualan_detail';
        $params['js'] = 'seller/penjualan_detail';

        $this->load_view($params,$data);
	}

	public function cetak($no_invoice = null, $no_transaksi = null, $user_id = null)
	{
		if ($no_invoice == null || $user_id == null || $no_transaksi == null) {
			header('location: '.base_url('404'));
		}

		$data['user_id'] = $user_id;
		$data['no_invoice'] = $no_invoice;
		$data['no_transaksi'] = $no_transaksi;

		$data['title'] = 'Cetak Pembelian';
        $params['view'] = 'seller/cetak_pembelian';
        $params['js'] = 'seller/cetak_pembelian';

        $this->load_view($params,$data);
	}

	public function print($no_invoice = null, $no_transaksi = null, $user_id = null)
	{
		if ($no_invoice == null || $user_id == null || $no_transaksi == null) {
			header('location: '.base_url('404'));
		}

		$data['user_id'] = $user_id;
		$data['no_invoice'] = $no_invoice;
		$data['no_transaksi'] = $no_transaksi;

		$this->load->view('seller/cetak_pembelian_print', $data);
	}

}

/* End of file Order.php */
/* Location: .//F/xampp/htdocs/GitHub/JPMall/app/controllers/seller/Order.php */