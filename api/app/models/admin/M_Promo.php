<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Promo extends MY_Model {

	protected $tabel = 'mst_promo';

	public function __construct()
	{
		parent::__construct();
		$this->load->library('Upload_image','upload_image');
	}

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
										CONCAT('".base_url('')."', foto) as foto_promo,
										nama_promo,
										kode_promo,
										potongan,
										jangka_waktu,
										akhir_promo,
										status
									FROM
										$this->tabel
									LIMIT
										$pagination[Data_ke],$limit");
			
			$no = 0;
			foreach ($query->result_array() as $key) {
				$akhir_promo = date_diff(date_create($key['akhir_promo']),date_create());
				$hasil_akhir = $akhir_promo->days + $akhir_promo->invert;
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
					'status' => $key['status']
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

	function add($params)
	{
		$foto = isset($params['foto'])? $params['foto'] : '';
		$nama_promo = isset($params['nama_promo'])? $params['nama_promo'] : '';
		$kode_promo = isset($params['kode_promo'])? $params['kode_promo'] : '';
		$potongan = isset($params['potongan'])? $params['potongan'] : '';
		$auto_generate = isset($params['auto_generate'])? $params['auto_generate'] : '';
		$jangka_waktu = isset($params['jangka_waktu'])? $params['jangka_waktu'] : '';
		$status = isset($params['status'])? $params['status'] : '';
		if (empty($foto)) {
			$result['Error'] = true;
			$result['Message'] = "Foto tidak boleh kosong";
			goto output;
		}else if(empty($nama_promo)) {
			$result['Error'] = true;
			$result['Message'] = "Nama Promo tidak boleh kosong";
			goto output;
		}else if(empty($potongan)) {
			$result['Error'] = true;
			$result['Message'] = "Potongan tidak boleh kosong";
			goto output;
		}else if(empty($jangka_waktu)) {
			$result['Error'] = true;
			$result['Message'] = "Jangka Waktu tidak boleh kosong";
			goto output;
		}

		if ($auto_generate == 1) {
			
			$generate_kode = random_string('alpha',6);

		}else if($auto_generate == 0) {

			if (empty($kode_promo)) {
				$result['Error'] = true;
				$result['Message'] = "Kode Promo tidak boleh kosong";
				goto output;
			}else if(strlen($kode_promo) < 6) {
				$result['Error'] = true;
				$result['Message'] = "Kode Promo minimal 6 karakter";
				goto output;
			}else if(strlen($kode_promo) > 8) {
				$result['Error'] = true;
				$result['Message'] = "Kode Promo maksimal 8 karakter";
				goto output;
			}

			$generate_kode = $kode_promo;

		}

		$cek_kode = $this->db->query("SELECT
										id as id_promo
									FROM
										$this->tabel
									WHERE
										kode_promo = '$generate_kode'")->row_array();
		if ($cek_kode) {
			$result['Error'] = true;
			$result['Message'] = "Kode Promo tidak tersedia";
			goto output;
		}

		$cek_nama_promo = $this->db->query("SELECT
										id as id_promo
									FROM
										$this->tabel
									WHERE
										nama_promo = '$nama_promo'")->row_array();
		if ($cek_nama_promo) {
			$result['Error'] = true;
			$result['Message'] = "Nama Promo tidak tersedia";
			goto output;
		}

		$upload = $this->upload_image->upload($foto,'Foto-promo','promo');

		$akhir_promo = date("Y-m-d", strtotime("+".$jangka_waktu." days", strtotime(date("Y-m-d"))));

		$data = [
			'foto' => $upload['Url'],
			'nama_promo' => $nama_promo,
			'kode_promo' => strtoupper($generate_kode),
			'potongan' => $potongan,
			'slug' => $this->generate_slug($nama_promo),
			'jangka_waktu' => $jangka_waktu,
			'akhir_promo' => $akhir_promo,
			'status' => $status
		];

		$config['tabel'] = $this->tabel;
		$config['data'] = $data;
		$config['pesan_sukses'] = "Berhasil menambahkan Promo";

		$result = $this->query_add($config);
		goto output;
		output:
		return $result;


	}

	function edit($params)
	{
		$id_promo = isset($params['id_promo'])? $params['id_promo'] : '';
		$kode_promo = isset($params['kode_promo'])? $params['kode_promo'] : '';
		$foto = isset($params['foto'])? $params['foto'] : '';
		$nama_promo = isset($params['nama_promo'])? $params['nama_promo'] : '';
		$potongan = isset($params['potongan'])? $params['potongan'] : '';
		$jangka_waktu = isset($params['jangka_waktu'])? $params['jangka_waktu'] : '';
		$status = isset($params['status'])? $params['status'] : '';
		if(empty($id_promo)) {
			$result['Error'] = true;
			$result['Message'] = "Parameter 'id_promo' tidak diset";
			goto output;
		}if(empty($kode_promo)) {
			$result['Error'] = true;
			$result['Message'] = "Parameter 'kode_promo' tidak diset";
			goto output;
		}else if(empty($nama_promo)) {
			$result['Error'] = true;
			$result['Message'] = "Nama Promo tidak boleh kosong";
			goto output;
		}else if(empty($potongan)) {
			$result['Error'] = true;
			$result['Message'] = "Potongan tidak boleh kosong";
			goto output;
		}else if(empty($jangka_waktu)) {
			$result['Error'] = true;
			$result['Message'] = "Jangka Waktu tidak boleh kosong";
			goto output;
		}

		$query = $this->db->query("SELECT
										id as id_promo,
										foto as foto_promo,
										nama_promo,
										kode_promo,
										potongan,
										status
									FROM
										$this->tabel
									WHERE
										id = $id_promo
									AND
										kode_promo = '$kode_promo'")->row_array();
		if ($query) {

			$upload = [
				'Url' => $query['foto_promo']
			];

			if (!empty($foto)) {
				$upload = $this->upload_image->upload($foto,'Foto-promo','promo',$query['foto_promo']);
			}		

			if ($nama_promo !== $query['nama_promo']) {
				$cek_nama_promo = $this->db->query("SELECT
														id as id_promo
													FROM
														$this->tabel
													WHERE
														nama_promo = '$nama_promo'")->row_array();
				if ($cek_nama_promo) {
					$result['Error'] = true;
					$result['Message'] = "Nama Promo tidak tersedia";
					goto output;
				}
			}

			$akhir_promo = date("Y-m-d", strtotime("+".$jangka_waktu." days", strtotime(date("Y-m-d"))));

			$data = [
				'foto' => $upload['Url'],
				'nama_promo' => $nama_promo,
				'potongan' => $potongan,
				'akhir_promo' => $akhir_promo,
				'status' => $status
			];

			$config['tabel'] = $this->tabel;
			$config['data'] = $data;
			$config['filter'] = "kode_promo = '$kode_promo'";
			$config['pesan_sukses'] = "Berhasil mengubah promo ".$nama_promo;
			$result = $this->query_update($config);
			goto output;
		}

		$result['Error'] = true;
		$result['Message'] = "Promo tidak ditemukan";
		goto output;
		output:
		return $result;

	}

	function delete($params)
	{
		$id_promo = isset($params['id_promo'])? $params['id_promo'] : '';
		$kode_promo = isset($params['kode_promo'])? $params['kode_promo'] : '';
		if(empty($kode_promo)) {
			$result['Error'] = true;
			$result['Message'] = "Parameter 'kode_promo' tidak diset";
			goto output;
		}else if(empty($kode_promo)) {
			$result['Error'] = true;
			$result['Message'] = "Parameter 'kode_promo' tidak diset";
			goto output;
		}

		$query = $this->db->query("SELECT
										id as id_promo,
										foto as foto_promo,
										nama_promo,
										kode_promo,
										potongan,
										status
									FROM
										$this->tabel
									WHERE
										id = $id_promo
									AND
										kode_promo = '$kode_promo'")->row_array();
		if ($query) {

			$config['tabel'] = $this->tabel;
			$config['data'] = ['status' => 0];
			$config['filter'] = "kode_promo = '$kode_promo'";
			$config['pesan_sukses'] = "Berhasil menghapus promo ".$query['nama_promo'];
			$result = $this->query_delete($config);
			if ($result['Error'] == false) {
				$this->upload_image->remove($query['foto_promo']);
			}
			goto output;
		}

		$result['Error'] = true;
		$result['Message'] = "Promo tidak ditemukan";
		goto output;
		output:
		return $result;

	}

}

/* End of file M_Promo.php */
/* Location: .//F/xampp/htdocs/com/JPStore/api/base/models/admin/M_Promo.php */