<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Slider extends MY_Model {

	protected $tabel = 'mst_slider';

	function all($params)
	{
		$query = $this->db->query("SELECT
										id as id_slider,
										banner as banner_slider,
										title,
										slug,
										status
									FROM
										$this->tabel
									WHERE
										status = 1");
		if ($query->num_rows() > 0) {

			$no = 0;
			foreach ($query->result_array() as $key) {
				$result['Error'] = false;
				$result['Message'] = null;
				$result['Data'][$no++] = $key;
			}
			goto output;

		}

		$result['Error'] = false;
		$result['Message'] = "Data tidak ditemukan";
		goto output;

		output:

		return $result;
	}

}

/* End of file M_Slider.php */
/* Location: .//F/xampp/htdocs/com/JPStore/api/base/models/M_Slider.php */