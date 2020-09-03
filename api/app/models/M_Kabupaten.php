<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Kabupaten extends MY_Model {

	protected $tabel = 'mst_kabupaten';

	function all($params)
	{
		$provinsi_id = isset($params['provinsi_id'])? $params['provinsi_id'] : '';
		if (empty($provinsi_id)) {
			$result['Error'] = true;
			$result['Message'] = "Parameter 'provinsi_id' tidak diset";
			goto output;
		}

		$query = $this->db->query("SELECT
										id as id_kabupaten,
										CONCAT(type, ' ', nama) as nama_kabupaten
									FROM	
										$this->tabel
									WHERE
										provinsi_id = $provinsi_id");
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

	function kodepos($kabupaten_id)
	{
		$query = $this->db->query("SELECT
										kode_pos as kodepos
									FROM 
										$this->tabel
									WHERE
										id = $kabupaten_id")->row_array();
		$result = $query? $query['kodepos'] : null;
		return $result;
	}

	function get($id_kabupaten)
	{
		$query = $this->db->query("SELECT
										id as kabupaten_id,
										nama as nama_kabupaten
									FROM
										$this->tabel
									WHERE
										id = $id_kabupaten")->row_array();
			

		$result = $query? $query : null;

		return $result;
	}

}

/* End of file M_Kabupaten.php */
/* Location: .//F/xampp/htdocs/com/JPStore/api/base/models/M_Kabupaten.php */