<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Category extends MY_Model {

	protected $tabel = 'mst_kategori';

	function all($params)
	{
		$query = $this->db->query("SELECT
										id as id_kategori,
										icon as icon_kategori,
										kategori_id,
										nama_kategori,
										slug
									FROM
										$this->tabel
									WHERE
										kategori_id = 0
									OR
										kategori_id = null
									ORDER BY
										urutan ASC
									");
		if ($query->num_rows() > 0) {

		
			$no = 0;
			foreach ($query->result_array() as $key) {
				$result['Error']		= false;
				$result['Message']		= null;
				$result['Data'][$no++]  = [
					'id_kategori' => $key['id_kategori'],
					'icon_kategori' => $key['icon_kategori'],
					'sub_kategori' => $this->sub_kategori($key['id_kategori']),
					'nama_kategori' => $key['nama_kategori'],
					'slug' => $key['slug']
				];
			}
			goto output;

		}

		$result['Error'] = true;
		$result['Message'] = "Data tidak ditemukan";
		goto output;
		output:
		return $result;
	}

	private function sub_kategori($id_kategori)
	{
		$query = $this->db->query("SELECT
										id as id_kategori,
										icon as icon_kategori,
										kategori_id,
										nama_kategori,
										slug
									FROM
										$this->tabel
									WHERE
										kategori_id = $id_kategori");
		$result = array();
		if ($query->num_rows() > 0) {
			$no = 0;
			foreach ($query->result_array() as $key) {
				$result[$no++]  = [
					'id_kategori' => $key['id_kategori'],
					'icon_kategori' => $key['icon_kategori'],
					'sub_kategori' => $this->sub_kategori($key['id_kategori']),
					'nama_kategori' => $key['nama_kategori'],
					'slug' => $key['slug']
				];
			}
		}
		return $result;
	}

	function sub($params)
	{
		$kategori_id = isset($params['kategori_id'])? $params['kategori_id'] : '';
		if (empty($kategori_id)) {
			$result['Error'] = true;
			$result['Message'] = "Parameter 'kategori_id' tidak diset";
			goto output;
		}

		$query = $this->db->query("SELECT
										id as id_kategori
									FROM
										$this->tabel
									WHERE
										id = $kategori_id");
		if ($query->num_rows() > 0) {
			
			$kategori = $query->row_array();

			$query = $this->db->query("SELECT
										id as id_kategori,
										icon as icon_kategori,
										kategori_id,
										nama_kategori,
										slug
									FROM
										$this->tabel
									WHERE
										kategori_id = $kategori[id_kategori]");
			if ($query->num_rows() > 0) {
				$no = 0;
				foreach ($query->result_array() as $key) {
					$result['Error'] = false;
					$result['Message'] = null;
					$result['Data'][$no++]  = [
						'id_kategori' => $key['id_kategori'],
						'icon_kategori' => $key['icon_kategori'],
						'sub_kategori' => $this->sub_kategori($key['id_kategori']),
						'nama_kategori' => $key['nama_kategori'],
						'slug' => $key['slug']
					];
				}
				goto output;
			}
			$result['Error'] = true;
			$result['Message'] = "Tidak ada sub kategori";
			goto output;

		}
		$result['Error'] = true;
		$result['Message'] = "Kategori tidak ditemukan";
		goto output;
		output:
		return $result;
	}

	function list($params)
	{
		$query = $this->db->query("SELECT
										id as id_kategori,
										icon as icon_kategori,
										kategori_id,
										nama_kategori,
										slug
									FROM
										$this->tabel");
		if ($query->num_rows() > 0) {

		
			$no = 0;
			foreach ($query->result_array() as $key) {
				$result['Error']		= false;
				$result['Message']		= null;
				$result['Data'][$no++]  = [
					'id_kategori' => $key['id_kategori'],
					'icon_kategori' => $key['icon_kategori'],
					'induk_kategori' => $this->induk_kategori($key['kategori_id'])['nama_kategori'],
					'slug_induk_kategori' => $this->induk_kategori($key['kategori_id'])['slug'],
					'nama_kategori' => $key['nama_kategori'],
					'slug' => $key['slug']
				];
			}
			goto output;

		}

		$result['Error'] = true;
		$result['Message'] = "Data tidak ditemukan";
		goto output;
		output:
		return $result;
	}

	private function induk_kategori($kategori_id)
	{
		$query = $this->db->query("SELECT
										id as id_kategori,
										icon as icon_kategori,
										kategori_id,
										nama_kategori,
										slug
									FROM
										$this->tabel
									WHERE 
										id = $kategori_id")->row_array();
		$result = $query? $query : null;
		return $result;
	}

	public function subKategori($params)
	{
		$kategori_id = $params['kategori_id'];

		if (empty($kategori_id)) {
			$hasil = array(
				'Error' => true,
				'Message' => "Parameter 'kategori_id' tidak diset."
			);
			goto output;
		}else{
			$cek_kategori = $this->db->query("
				SELECT
					id
				FROM
					$this->tabel
				WHERE
					id = '$kategori_id'
			")->num_rows();

			if ($cek_kategori == 0) {
				$hasil = array(
					'Error' => true,
					'Message' => "Kategori tidak ditemukan."
				);
				goto output;
			}

			$query = $this->db->query("
				SELECT
					id as id_kategori,
					CONCAT('".base_url('')."', icon) as icon_kategori,
					kategori_id,
					nama_kategori,
					slug
				FROM
					$this->tabel
				WHERE
					kategori_id = $kategori_id
			");
			$no = 0;
			$hasil['Error'] = false;
			$hasil['Message'] = "success.";
			$hasil['Data'] = array();
			foreach ($query->result_array() as $key) {
				$hasil['Data'][$no++]  = [
					'id_kategori' => $key['id_kategori'],
					'icon_kategori' => $key['icon_kategori'],
					'nama_kategori' => $key['nama_kategori'],
					'slug' => $key['slug']
				];
			}
			goto output;
		}

		output:
		return $hasil;
	}

}

/* End of file M_Category.php */
/* Location: .//F/xampp/htdocs/com/JPStore/api/base/models/M_Category.php */