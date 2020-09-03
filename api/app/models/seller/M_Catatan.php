<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Catatan extends MY_Model {

	protected $tabel = 'mst_toko_catatan';

	protected $tabel_user = 'mst_user';

	protected $tabel_toko = 'mst_toko';

	function all($params)
	{
		$client_token = isset($params['client_token'])? $params['client_token'] : '';
		$limit = isset($params['limit'])? $params['limit'] : 10;
		$page = isset($params['page'])? $params['page'] : 1;
		if (empty($client_token)) {
			$result['Error'] = true;
			$result['Message'] = "Parameter client_token tidak diset";
			goto output;
		}

		$user = $this->db->query("SELECT
										id
									FROM
										$this->tabel_user
									WHERE
										api_token = '$client_token'")->row_array();
		if (empty($user)) {
			$result['Error'] = true;
			$result['Message'] = "Pengguna tidak ditemukan";
			goto output;
		}

		$toko = $this->db->query("SELECT
										id
									FROM
										$this->tabel_toko
									WHERE
										user_id = '$user[id]'")->row_array();
		if (empty($toko)) {
			$result['Error'] = true;
			$result['Message'] = "Toko tidak ditemukan";
			goto output;
		}

		$jumlah_catatan = $this->db->query("SELECT
										id,
										toko_id,
										judul,
										teks
									FROM
										$this->tabel
									WHERE
										toko_id = '$toko[id]'")->num_rows();
		if ($jumlah_catatan > 0) {
			
			$config['jumlah_data'] = $jumlah_catatan;
			$config['limit'] = $limit;
			$config['page']	= $page;

			$pagination = $this->query_pagination($config);

			$data = $this->db->query("SELECT
										id,
										toko_id,
										judul,
										teks
									FROM
										$this->tabel
									WHERE
										toko_id = '$toko[id]'
									LIMIT
										$pagination[Data_ke],$limit")->result_array();

			$no = 0;
			foreach($data as $key){
				$result['Error'] = false;
				$result['Message'] = null;
				$result['Pagination'] = $pagination;
				$result['Data'][$no++] = $key;
			}
			goto output;
		}
		$result['Error'] = true;
		$result['Message'] = "Catatan tidak ditemukan";
		goto output;
		output:
		return $result;
	}

	function add($params)
	{
		$client_token = isset($params['client_token'])? $params['client_token'] : '';
		$judul = isset($params['judul'])? $params['judul'] : '';
		$teks = isset($params['teks'])? $params['teks'] : '';
		if (empty($client_token)) {
			$result['Error'] = true;
			$result['Message'] = "Parameter client_token tidak diset";
			goto output;
		}else if(empty($judul)) {
			$result['Error'] = true;
			$result['Message'] = "Judul harus diisi";
			goto output;
		}else if(empty($teks)) {
			$result['Error'] = true;
			$result['Message'] = "Teks harus diisi";
			goto output;
		}

		$user = $this->db->query("SELECT
										id
									FROM
										$this->tabel_user
									WHERE
										api_token = '$client_token'")->row_array();
		if (empty($user)) {
			$result['Error'] = true;
			$result['Message'] = "Pengguna tidak ditemukan";
			goto output;
		}

		$toko = $this->db->query("SELECT
										id
									FROM
										$this->tabel_toko
									WHERE
										user_id = '$user[id]'")->row_array();
		if (empty($toko)) {
			$result['Error'] = true;
			$result['Message'] = "Toko tidak ditemukan";
			goto output;
		}

// 		$judul_catatan = $this->db->query("SELECT
// 							id
// 						FROM
// 							$this->tabel
// 						WHERE
// 							judul = '$judul'")->num_rows();
// 		if ($judul_catatan > 1) {
// 			$result['Error'] = true;
// 			$result['Message'] = "Judul telah digunakan";
// 			goto output;
// 		}

		$data = [
			'toko_id' => $toko['id'],
			'judul' => $judul,
			'teks' => $teks
		];

		$add = $this->db->insert($this->tabel,$data);
		if ($add) {
			$result['Error'] = false;
			$result['Message'] = "Berhasil menambahkan catatan";
			goto output;
		}
		$result['Error'] = true;
		$result['Message'] = "Gagal menambahkan catatan";
		$result['Debug'] = $this->db->error();
		goto output;
		output:
		return $result;
	}

	function update($params)
	{
		$client_token = isset($params['client_token'])? $params['client_token'] : '';
		$catatan_id = isset($params['catatan_id'])? $params['catatan_id'] : '';
		$judul = isset($params['judul'])? $params['judul'] : '';
		$teks = isset($params['teks'])? $params['teks'] : '';
		if (empty($client_token)) {
			$result['Error'] = true;
			$result['Message'] = "Parameter client_token tidak diset";
			goto output;
		}else if(empty($catatan_id)) {
			$result['Error'] = true;
			$result['Message'] = "Parameter catatan_id tidak diset";
			goto output;
		}else if(empty($judul)) {
			$result['Error'] = true;
			$result['Message'] = "Judul harus diisi";
			goto output;
		}else if(empty($teks)) {
			$result['Error'] = true;
			$result['Message'] = "Teks harus diisi";
			goto output;
		}

		$user = $this->db->query("SELECT
										id
									FROM
										$this->tabel_user
									WHERE
										api_token = '$client_token'")->row_array();
		if (empty($user)) {
			$result['Error'] = true;
			$result['Message'] = "Pengguna tidak ditemukan";
			goto output;
		}

		$toko = $this->db->query("SELECT
										id
									FROM
										$this->tabel_toko
									WHERE
										user_id = '$user[id]'")->row_array();
		if (empty($toko)) {
			$result['Error'] = true;
			$result['Message'] = "Toko tidak ditemukan";
			goto output;
		}

// 		$judul_catatan = $this->db->query("SELECT
// 							id
// 						FROM
// 							$this->tabel
// 						WHERE
// 							judul = '$judul'")->num_rows();
// 		if ($judul_catatan > 1) {
// 			$result['Error'] = true;
// 			$result['Message'] = "Judul telah digunakan";
// 			goto output;
// 		}

		$data = [
			'judul' => $judul,
			'teks' => $teks
		];

		$update = $this->db->update($this->tabel,$data,['id' => $catatan_id]);
		if ($update) {
			$result['Error'] = false;
			$result['Message'] = "Berhasil mengubah catatan";
			goto output;
		}
		$result['Error'] = true;
		$result['Message'] = "Gagal mengubah catatan";
		goto output;
		output:
		return $result;
	}

	function delete($params)
	{
		$client_token = isset($params['client_token'])? $params['client_token'] : '';
		$catatan_id = isset($params['catatan_id'])? $params['catatan_id'] : '';
		if (empty($client_token)) {
			$result['Error'] = true;
			$result['Message'] = "Parameter client_token tidak diset";
			goto output;
		}else if(empty($catatan_id)) {
			$result['Error'] = true;
			$result['Message'] = "Parameter catatan_id tidak diset";
			goto output;
		}

		$user = $this->db->query("SELECT
										id
									FROM
										$this->tabel_user
									WHERE
										api_token = '$client_token'")->row_array();
		if (empty($user)) {
			$result['Error'] = true;
			$result['Message'] = "Pengguna tidak ditemukan";
			goto output;
		}

		$toko = $this->db->query("SELECT
										id
									FROM
										$this->tabel_toko
									WHERE
										user_id = '$user[id]'")->row_array();
		if (empty($toko)) {
			$result['Error'] = true;
			$result['Message'] = "Toko tidak ditemukan";
			goto output;
		}

		$delete = $this->db->delete($this->tabel,['id' => $catatan_id]);
		if ($delete) {
			$result['Error'] = false;
			$result['Message'] = "Berhasil menghapus catatan";
			goto output;
		}
		$result['Error'] = true;
		$result['Message'] = "Gagal menghapus catatan";
		goto output;
		output:
		return $result;
	}

}

/* End of file M_Catatan.php */
/* Location: .//F/Server/www/jpstore/api/app/models/seller/M_Catatan.php */