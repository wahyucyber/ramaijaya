<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_Tracking extends MY_Model
{
	/**
	* @author          Masteguh
	* @link            https://github.com/AnteikuDevs
	*/

	protected $tabel_transaksi = 'mst_transaksi';

	protected $tabel_transaksi_detail = 'mst_transaksi_detail';

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_Ongkir', 'ongkir');
	}

	public function index()
	{
	    $detail = $this->db->query("SELECT
                                	    $this->tabel_transaksi_detail.id,
										$this->tabel_transaksi_detail.kurir_resi,
										$this->tabel_transaksi_detail.kurir_code
									FROM
										$this->tabel_transaksi_detail
										LEFT JOIN $this->tabel_transaksi ON $this->tabel_transaksi_detail.transaksi_id=$this->tabel_transaksi.id
									WHERE
										$this->tabel_transaksi.status='1'
										AND
										$this->tabel_transaksi_detail.status='3'")->result_array();
	    $update_data = [];
	    $data = [];
	    $no = 0;
	    $no_data = 0;
	    foreach ($detail as $key) {
	    	$tracking = $this->ongkir->get_tracking(['no_resi' => $key['kurir_resi'],'courier_code' => $key['kurir_code']]);
	    	if ($tracking['Error']) {
	    	}else{
	    		$pod_date = new DateTime($tracking['delivery_status']['pod_date']);
				$now = new DateTime(date('Y-m-d'));
				$delivered = $pod_date->diff($now)->d;
				if ($delivered >= 3) {
					$update_data[$no++] = array(
					   'id' => $key['id'],
					   'status' => '4'
					);
				}
	    	}
			$data[$no_data++] = $tracking;
	    }
	    $this->db->update_batch($this->tabel_transaksi_detail, $update_data, 'id');
	    return [
	    	'Error' => false,
	    	'Message' => 'Success.',
	    	'Data' => $update_data
	    ];
	}
}