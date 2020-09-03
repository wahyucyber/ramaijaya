<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Promo extends MY_Model {

	protected $tabel = 'mst_promo';

	function all($params)
	{
		$keyword = isset($params['keyword'])? $params['keyword'] : '';
		$limit = isset($params['limit'])? $params['limit'] : 10;
		$query = $this->db->query("SELECT
										id as id_promo,
										foto as foto_promo,
										nama_promo,
										kode_promo,
										potongan,
										jangka_waktu,
										akhir_promo,
										status
									FROM
										$this->tabel");
		if ($query->num_rows() > 0) {

			$config['jumlah_data'] = $query->num_rows();
			$config['limit'] = $limit;
			$config['page']	= empty($params['page'])? null : $params['page'];

			$pagination = $this->query_pagination($config);

			$query = $this->db->query("SELECT
											id as id_promo,
											foto as foto_promo,
											nama_promo,
											kode_promo,
											potongan,
											jangka_waktu,
											akhir_promo,
											status,
											slug
										FROM
											$this->tabel
										ORDER BY id DESC
										LIMIT
											$pagination[Data_ke],$limit");
				
			$no = 0;
			foreach ($query->result_array() as $key) {
				$akhir_promo = date_diff(date_create($key['akhir_promo']),date_create());
				$hasil_akhir = $akhir_promo->days + $akhir_promo->invert;

				$this->check_expired($key['id_promo']);

				$result['Error'] = false;
				$result['Message'] = null;
				$result['Data'][$no++] = [
					'id_promo' => $key['id_promo'],
					'foto_promo' => $key['foto_promo'],
					'nama_promo' => $key['nama_promo'],
					'kode_promo' => $key['kode_promo'],
					'potongan' => $key['potongan'],
					'jangka_waktu' => $key['jangka_waktu'],
					'akhir_promo' => "$hasil_akhir",
					'status' => $key['status'],
					'slug' => $key['slug']
				];
				$result['Pagination'] = $pagination;
			}
			goto output;

		}
		$result['Error'] = true;
		$result['Message'] = "Tidak ada promo ditemukan";
		goto output;
		output:
		return $result;
	}

	function check_expired($id_promo)
	{
		$query = $this->db->query("SELECT
										id as id_promo,
										foto as foto_promo,
										nama_promo,
										kode_promo,
										potongan,
										jangka_waktu,
										akhir_promo,
										status,
										slug
									FROM
										$this->tabel
									WHERE
										id = $id_promo")->row_array();
		if ($query) {
			
			if (strtotime($query['akhir_promo']) <= strtotime(date('Y-m-d')) ) {
				$this->db->delete($this->tabel,['id' => $query['id_promo']]);
			}

		}
	}

}

/* End of file M_Promo.php */
/* Location: .//F/xampp/htdocs/com/JPStore/api/base/models/M_Promo.php */