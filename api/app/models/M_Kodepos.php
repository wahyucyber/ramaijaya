<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Kodepos extends MY_Model {

	protected $tabel = 'mst_kecamatan';

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_Kabupaten','kabupaten');
	}

	function all($params)
	{
		$kecamatan_id = isset($params['kecamatan_id'])? $params['kecamatan_id'] : '';

		if (empty($kecamatan_id)) {
			$result['Error'] = true;
			$result['Message'] = "Parameter 'kecamatan_id' tidak diset";
			goto output;
		}

		$query = $this->db->query("SELECT
												id as id_kecamatan,
												nama as nama_kecamatan,
												kabupaten_id
											FROM
												$this->tabel
											WHERE
												id = $kecamatan_id")->row_array();
		if ($query) {
			$result['Error'] = false;
			$result['Message'] = null;
			$result['Data'] = [
				'kodepos' => $this->kabupaten->kodepos($query['kabupaten_id'])
			];
			goto output;
		}

		$result['Error'] = true;
		$result['Message'] = "Data tidak ditemukan";
		goto output;
		output:

		return $result;
	}

}

/* End of file M_Kodepos.php */
/* Location: .//F/xampp/htdocs/com/JPStore/api/base/models/M_Kodepos.php */