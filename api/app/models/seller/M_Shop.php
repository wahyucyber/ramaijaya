<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Shop extends MY_Model {

	protected $tabel = 'mst_toko';

	protected $tabel_user = 'mst_user';

	protected $tabel_provinsi = 'mst_provinsi';

	protected $tabel_kabupaten = 'mst_kabupaten';

	protected $tabel_kecamatan = 'mst_kecamatan';

	public function __construct()
	{
		parent::__construct();
		$this->load->library('Upload_image','upload_image');
	}

	public function get($params)
	{
		$client_token = isset($params['client_token'])? $params['client_token'] : '';
		if (empty($client_token)) {
			$result['Error'] = true;
			$result['Message'] = "Parameter 'client_token' tidak diset";
			goto output;
		}

		$user = $this->db->query("SELECT
										id as id_user
									FROM
										$this->tabel_user
									WHERE
										api_token = '$client_token'")->row_array();
		if ($user) {
			
			$toko = $this->db->query("SELECT
								        $this->tabel.id as id_toko,
								        $this->tabel_user.id as id_user,
								        CONCAT('".base_url()."', $this->tabel.logo) AS logo_toko,
								        $this->tabel.banner as banner_toko,
								        $this->tabel.nama_toko,
								        $this->tabel.slogan,
								        $this->tabel.deskripsi,
								        $this->tabel.provinsi_id,
								        $this->tabel_provinsi.nama as nama_provinsi,
								        $this->tabel.kabupaten_id,
								        $this->tabel_kabupaten.nama as nama_kabupaten,
								        $this->tabel.kecamatan_id,
								        $this->tabel_kecamatan.nama as nama_kecamatan,
								        $this->tabel_kabupaten.kode_pos,
								        $this->tabel.slug,
								        $this->tabel.status as status_toko,
								        $this->tabel.power_merchant,
								        $this->tabel.buka as buka_toko,
								        $this->tabel.awal_tutup,
								        $this->tabel.akhir_tutup,
								        $this->tabel.catatan_tutup,
								        $this->tabel.bank_nama,
								        $this->tabel.bank_atasnama,
								        $this->tabel.bank_rekening
									FROM
										$this->tabel
								    LEFT JOIN
										$this->tabel_user
										ON
											$this->tabel.user_id=$this->tabel_user.id
									LEFT JOIN
										$this->tabel_provinsi
										ON
											$this->tabel.provinsi_id=$this->tabel_provinsi.id
									LEFT JOIN
										$this->tabel_kabupaten
										ON
											$this->tabel.kabupaten_id=$this->tabel_kabupaten.id
									LEFT JOIN
										$this->tabel_kecamatan
										ON
											$this->tabel.kecamatan_id=$this->tabel_kecamatan.id
									WHERE
										user_id = $user[id_user]")->row_array();

			if ($toko) {

				$result['Error'] = false;
				$result['Message'] = null;
				$result['Data'] = $toko;
				goto output;

			}
			$result['Error'] = true;
			$result['Message'] = "Toko tidak ditemukan";
			goto output;


		}

		$result['Error'] = true;
		$result['Message'] = "Pengguna tidak ditemukan";
		goto output;
		output:
		return $result;
	}

	public function edit($params)
	{
		$client_token = $params['client_token'];
		$logo = $params['logo'];
		$nama = $params['nama'];
		$slogan = $params['slogan'];
		$deskripsi = $params['deskripsi'];
		$bank = $params['bank'];
		$atasnama = $params['atasnama'];
		$rekening = $params['rekening'];

		if (empty($client_token)) {
			$hasil = array(
				'Error' => true,
				'Message' => "Parameter 'client_token' tidak diset."
			);
			goto output;
		}else if (empty($nama)) {
			$hasil = array(
				'Error' => true,
				'Message' => "Nama toko belum diisi."
			);
			goto output;
		}else if (empty($slogan)) {
			$hasil = array(
				'Error' => true,
				'Message' => "Slogan belum diisi."
			);
			goto output;
		}else if (empty($deskripsi)) {
			$hasil = array(
				'Error' => true,
				'Message' => "Deskripsi belum diisi."
			);
			goto output;
		}else if (empty($bank)) {
			$hasil = array(
				'Error' => true,
				'Message' => "Bank belum diisi."
			);
			goto output;
		}else if (empty($atasnama)) {
			$hasil = array(
				'Error' => true,
				'Message' => "Atasnama belum diisi."
			);
			goto output;
		}else if (empty($rekening)) {
			$hasil = array(
				'Error' => true,
				'Message' => "Rekening belum diisi."
			);
			goto output;
		}else{
			$user_id = $this->get_user_id($client_token);

			if ($user_id == null) {
				$hasil = array(
					'Error' => true,
					'Message' => "User tidak ditemukan."
				);
				goto output;
			}

			$cek_toko = $this->db->query("
				SELECT
					logo
				FROM
					$this->tabel
				WHERE
					user_id = '$user_id'
			");

			if ($cek_toko->num_rows() == 0) {
				$hasil = array(
					'Error' => true,
					'Message' => "Anda belum memiliki toko"
				);
				goto output;
			}

			$cek_nama_toko = $this->db->query("SELECT
													id as id_toko
												FROM
													$this->tabel
												WHERE
													nama_toko = '$nama'")->num_rows();
			if ($cek_nama_toko > 1) {
				$hasil = array(
					'Error' => true,
					'Message' => "Nama toko tidak tersedia"
				);
				goto output;
			}

			if (!empty($logo)) {
				$logo_old = $cek_toko->row_array()['logo'];
				$new_image = $this->upload_image->upload($img, "Foto-toko", 'toko', (empty($logo_old)) ? "":$logo_old);
				$data['logo'] = $new_image['Url'];
			}

			$data['nama_toko'] = $nama;
			$data['slogan'] = $slogan;
			$data['deskripsi'] = $deskripsi;
			$data['bank_nama'] = $bank;
			$data['bank_atasnama'] = $atasnama;
			$data['bank_rekening'] = $rekening;

			$this->db->update($this->tabel, $data, array(
				'user_id' => $user_id
			));

			$hasil = array(
				'Error' => false,
				'Message' => "Profil toko berhasil diperbarui."
			);
			goto output;
		}

		output:
		return $hasil;
	}

	public function upload_logo($params)
	{
		$client_token = $params['client_token'];
		$logo = $params['logo'];

		if (empty($client_token)) {
			$hasil = array(
				'Error' => true,
				'Message' => "Parameter 'client_token' tidak diset."
			);
			goto output;
		}else if (empty($logo)) {
			$hasil = array(
				'Error' => true,
				'Message' => "Logo belum dipilih."
			);
			goto output;
		}else{
			$user_id = $this->get_user_id($client_token);

			if ($user_id == null) {
				$hasil = array(
					'Error' => true,
					'Message' => "User tidak ditemukan."
				);
				goto output;
			}

			$cek_toko = $this->db->query("
				SELECT
					logo
				FROM
					$this->tabel
				WHERE
					user_id = '$user_id'
			");

			if ($cek_toko->num_rows() == 0) {
				$hasil = array(
					'Error' => true,
					'Message' => "Anda belum memiliki toko"
				);
				goto output;
			}

			$logo_old = $cek_toko->row_array()['logo'];
			$new_image = $this->upload_image->upload($logo, "Foto-toko", 'toko', (empty($logo_old)) ? "":$logo_old);
			$data['logo'] = $new_image['Url'];

			$this->db->update($this->tabel, $data, array(
				'user_id' => $user_id
			));

			$hasil = array(
				'Error' => false,
				'Message' => "Logo toko berhasil diperbarui."
			);
			goto output;
		}

		output:
		return $hasil;
	}

	public function upload_banner($params)
	{
		$client_token = $params['client_token'];
		$banner = $params['banner'];

		if (empty($client_token)) {
			$hasil = array(
				'Error' => true,
				'Message' => "Parameter 'client_token' tidak diset."
			);
			goto output;
		}else if (empty($banner)) {
			$hasil = array(
				'Error' => true,
				'Message' => "Banner belum dipilih."
			);
			goto output;
		}else{
			$user_id = $this->get_user_id($client_token);

			if ($user_id == null) {
				$hasil = array(
					'Error' => true,
					'Message' => "User tidak ditemukan."
				);
				goto output;
			}

			$cek_toko = $this->db->query("
				SELECT
					banner
				FROM
					$this->tabel
				WHERE
					user_id = '$user_id'
			");

			if ($cek_toko->num_rows() == 0) {
				$hasil = array(
					'Error' => true,
					'Message' => "Anda belum memiliki toko"
				);
				goto output;
			}

			$banner_old = $cek_toko->row_array()['banner'];
			$new_image = $this->upload_image->upload($banner, "Foto-toko", 'toko', (empty($banner_old)) ? "":$banner_old);
			$data['banner'] = $new_image['Url'];

			$this->db->update($this->tabel, $data, array(
				'user_id' => $user_id
			));

			$hasil = array(
				'Error' => false,
				'Message' => "Banner toko berhasil diperbarui."
			);
			goto output;
		}

		output:
		return $hasil;
	}

	public function status_toko($params)
	{
		$client_token = $params['client_token'];
		$dari_tanggal = $params['dari_tanggal'];
		$ke_tanggal = $params['ke_tanggal'];
		$tutup = $params['tutup'];
		$catatan = $params['catatan'];

		if(empty($client_token)) {
			$output = array(
				'Error' => true,
				'Message' => "client_token is required."
			);
			goto output;
		}

		$toko_id = $this->db->query("
			SELECT
				$this->tabel.id
			FROM
				$this->tabel_user
				LEFT JOIN $this->tabel ON $this->tabel.user_id = $this->tabel_user.id
			WHERE
				$this->tabel_user.api_token = '$client_token'
		")->row_array()['id'];

		if($tutup == 1) {
			$this->db->update($this->tabel, array(
				'awal_tutup' => null,
				'akhir_tutup' => null,
				'catatan_tutup' => $catatan,
				'buka' => '0'
			), array(
				'id' => $toko_id
			));
		}else if(!empty($dari_tanggal) && !empty($ke_tanggal)) {

			$tutup = "1";
			if(strtotime($dari_tanggal) <= strtotime(date("Y-m-d"))) {
				$tutup = "0";
			}

			$this->db->update($this->tabel, array(
				'awal_tutup' => $dari_tanggal,
				'akhir_tutup' => $ke_tanggal,
				'catatan_tutup' => $catatan,
				'buka' => $tutup
			), array(
				'id' => $toko_id
			));
		}else if(empty($tutup) && empty($dari_tanggal) && empty($ke_tanggal)) {
			$this->db->update($this->tabel, array(
				'awal_tutup' => NULL,
				'akhir_tutup' => NULL,
				'catatan_tutup' => NULL,
				'buka' => '1'
			), array(
				'id' => $toko_id
			));
		}

		$output = array(
			'Error' => false,
			'Message' => "status toko berhasil diperbarui."
		);

		output:
		return $output;
	}

}

/* End of file M_Shop.php */
/* Location: .//F/xampp/htdocs/com/JPStore/api/base/models/seller/M_Shop.php */