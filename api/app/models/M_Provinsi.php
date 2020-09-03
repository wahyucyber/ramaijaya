<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Provinsi extends MY_Model {

	protected $tabel = 'mst_provinsi';

	function all($params)
	{
		$query = $this->db->query("SELECT
										id as id_provinsi,
										nama as nama_provinsi
									FROM
										$this->tabel");
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

/* End of file M_Provinsi.php */
/* Location: .//F/xampp/htdocs/com/JPStore/api/base/models/M_Provinsi.php */