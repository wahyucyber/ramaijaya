<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Kecamatan extends MY_Model {

	protected $tabel = 'mst_kecamatan';

	function all($params)
	{
		$kabupaten_id = isset($params['kabupaten_id'])? $params['kabupaten_id'] : '';
		if (empty($kabupaten_id)) {
			$result['Error'] = true;
			$result['Message'] = "Parameter 'kabupaten_id' tidak diset";
			goto output;
		}

		$query = $this->db->query("SELECT
										id as id_kecamatan,
										nama as nama_kecamatan
									FROM	
										$this->tabel
									WHERE
										kabupaten_id = $kabupaten_id");
		if ($query->num_rows() > 0) {
			$no = 0;
			foreach ($query->result_array() as $key) {
				$result['Error'] = false;
				$result['Message'] = null;
				$result['Data'][$no++] = $key;
			}
			goto output;
		}

		$result['Error'] = true;
		$result['Message'] = "Data tidak ditemukan";
		goto output;
		output:
		return $result;
	}

}

/* End of file M_Kabupaten.php */
/* Location: .//F/xampp/htdocs/com/JPStore/api/base/models/M_Kabupaten.php */