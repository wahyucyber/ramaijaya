<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Transaction extends MY_Admin {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$data['title'] = 'Dashboard';
    	$params['view'] = 'admin/transaction';
        $params['js'] = 'admin/transaction';

        $this->load_view($params,$data);
	}

	public function detail($no_invoice = null, $user_id = null)
	{
		if ($no_invoice == null || $user_id == null) {
			header('location: '.base_url('404'));
		}

		$data['user_id'] = $user_id;
		$data['no_invoice'] = $no_invoice;
		$data['title'] = 'Transaksi Detail';
    	$params['view'] = 'admin/transaction_detail';
        $params['js'] = 'admin/transaction_detail';

        $this->load_view($params,$data);
	}

	public function pengajuan()
	{
		$data['title'] = 'Transaksi Pengajuan Pencairan';
    	$params['view'] = 'admin/transaction_pengajuan';
        $params['js'] = 'admin/transaction_pengajuan';

        $this->load_view($params,$data);
	}

	public function refund()
	{
		$data['title'] = 'Transaksi Pengajuan Refund';
    	$params['view'] = 'admin/transaction_refund';
        $params['js'] = 'admin/transaction_refund';

        $this->load_view($params,$data);
	}

	public function cetak($no_invoice = null, $user_id = null)
	{
		if ($no_invoice == null || $user_id == null) {
			header('location: '.base_url('404'));
		}

		$data['user_id'] = $user_id;
		$data['no_invoice'] = $no_invoice;

		$data['title'] = 'Cetak Pembelian';
        $params['view'] = 'admin/cetak_pembelian';
        $params['js'] = 'admin/cetak_pembelian';

        $this->load_view($params,$data);
	}

	public function print($no_invoice = null, $user_id = null)
	{
		if ($no_invoice == null || $user_id == null) {
			header('location: '.base_url('404'));
		}

		$data['user_id'] = $user_id;
		$data['no_invoice'] = $no_invoice;

		$this->load->view('admin/cetak_pembelian_print', $data);
	}

}

/* End of file Transaction.php */
/* Location: ./application/controllers/Transaction.php */