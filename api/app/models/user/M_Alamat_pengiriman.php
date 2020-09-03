<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_Alamat_pengiriman extends MY_Model {

	protected $tabel = 'mst_alamat_pengiriman';

	protected $tabel_provinsi = 'mst_provinsi';

	protected $tabel_kabupaten = 'mst_kabupaten';

	protected $tabel_kecamatan = 'mst_kecamatan';

	public function __construct()
	{
		parent::__construct();
	}

	public function add($params)
	{
		$client_token = $params['client_token'];
		$nama = $params['nama'];
		$penerima_nama = $params['penerima_nama'];
		$penerima_telepon = $params['penerima_telepon'];
		$provinsi = $params['provinsi'];
		$kabupaten = $params['kabupaten'];
		$kecamatan = $params['kecamatan'];
		$alamat = $params['alamat'];

		if (empty($client_token)) {
			$hasil = array(
				'Error' => true,
				'Message' => "Parameter 'client_token' tidak diset."
			);
			goto output;
		}else if (empty($nama)) {
			$hasil = array(
				'Error' => true,
				'Message' => "Nama belum diisi."
			);
			goto output;
		}else if (empty($penerima_nama)) {
			$hasil = array(
				'Error' => true,
				'Message' => "Nama penerima belum diisi."
			);
			goto output;
		}else if (empty($penerima_telepon)) {
			$hasil = array(
				'Error' => true,
				'Message' => "No. Telepon penerima belum diisi."
			);
			goto output;
		}else if (empty($provinsi)) {
			$hasil = array(
				'Error' => true,
				'Message' => "Provinsi belum dipilih."
			);
			goto output;
		}else if (empty($kabupaten)) {
			$hasil = array(
				'Error' => true,
				'Message' => "Kabupaten belum dipilih."
			);
			goto output;
		}else if (empty($kecamatan)) {
			$hasil = array(
				'Error' => true,
				'Message' => "Kecamatan belum diisi."
			);
			goto output;
		}else if (empty($alamat)) {
			$hasil = array(
				'Error' => true,
				'Message' => "Alamat belum diisi."
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

			$cek_nama = $this->db->query("
				SELECT
					id
				FROM
					$this->tabel
				WHERE
					nama = '$nama' AND
					user_id = '$user_id'
			")->num_rows();
			if ($cek_nama == 1) {
				$hasil = array(
					'Error' => true,
					'Message' => "Nama alamat pengiriman sudah terdaftar."
				);
				goto output;
			}

			$cek_data = $this->db->query("
				SELECT
					id
				FROM
					$this->tabel
				WHERE
					user_id = '$user_id'
			")->num_rows();

			if ($cek_data == 0) {
				$this->db->insert($this->tabel, array(
					'user_id' => $user_id,
					'nama' => $nama,
					'penerima_nama' => $penerima_nama,
					'penerima_no_telepon' => $penerima_telepon,
					'provinsi_id' => $provinsi,
					'kabupaten_id' => $kabupaten,
					'kecamatan_id' => $kecamatan,
					'alamat' => $alamat,
					'is_utama' => '1'
				));
			}else{
				$this->db->insert($this->tabel, array(
					'user_id' => $user_id,
					'nama' => $nama,
					'penerima_nama' => $penerima_nama,
					'penerima_no_telepon' => $penerima_telepon,
					'provinsi_id' => $provinsi,
					'kabupaten_id' => $kabupaten,
					'kecamatan_id' => $kecamatan,
					'alamat' => $alamat
				));
			}

			$hasil = array(
				'Error' => false,
				'Message' => "Alamat pengiriman berhasil disimpan."
			);
			goto output;
		}

		output:
		return $hasil;
	}

	public function list($params)
	{
		$client_token = $params['client_token'];
		$start = $params['start'];
		$length = $params['length'];
		$draw = $params['draw'];
		$id = $params['id'];
		$search = $params['search']['value'];

		if (empty($client_token)) {
			$hasil = array(
				'Error' => true,
				'Message' => "Parameter 'client_token' tidak diset."
			);
			goto output;
		}

		$user_id = $this->get_user_id($client_token);

		if ($user_id == null) {
			$hasil = array(
				'Error' => true,
				'Message' => "User tidak ditemukan."
			);
			goto output;
		}

		$where = "WHERE $this->tabel.user_id = '$user_id'";

		if (!empty($search)) {
			$where .= " AND $this->tabel.nama LIKE '%$search%'";
		}else if (!empty($id)) {
			$where .= " AND $this->tabel.id = '$id'";
		}else if (!empty($id) && !empty($search)) {
			$where .= " AND $this->tabel.nama LIKE '%$search%' AND $this->tabel.id = '$id'";
		}
		$limit = ($start != "" && !empty($length)) ? " LIMIT $start, $length":"";

		$get_data = $this->db->query("
			SELECT
				$this->tabel.id,
				$this->tabel.nama,
				$this->tabel.penerima_nama,
				$this->tabel.penerima_no_telepon,
				$this->tabel.provinsi_id,
				$this->tabel_provinsi.nama AS provinsi_nama,
				$this->tabel.kabupaten_id,
				CONCAT($this->tabel_kabupaten.type, ' ', $this->tabel_kabupaten.nama) AS kabupaten_nama,
				$this->tabel.kecamatan_id,
				$this->tabel_kecamatan.nama AS kecamatan_nama,
				$this->tabel.alamat,
				$this->tabel.is_utama,
				$this->tabel.created_at,
				$this->tabel.updated_at
			FROM
				$this->tabel
				LEFT JOIN $this->tabel_provinsi ON $this->tabel_provinsi.id = $this->tabel.provinsi_id
				LEFT JOIN $this->tabel_kabupaten ON $this->tabel_kabupaten.id = $this->tabel.kabupaten_id
				LEFT JOIN $this->tabel_kecamatan ON $this->tabel_kecamatan.id = $this->tabel.kecamatan_id
			$where
			$limit
		")->result_array();
		$no = 0;
		$hasil['Error'] = false;
		$hasil['Message'] = "success.";
		$hasil['Data'] = array();
		foreach ($get_data as $key) {
			$hasil['Data'][$no++] = $key;
		}
		$hasil['query'] = $where;
		$hasil['recordsTotal'] = $this->recordsTotal($this->tabel." WHERE user_id = '$user_id'");
		$hasil['recordsFiltered'] = $this->recordsFiltered($this->tabel, 'id', "$this->tabel.nama LIKE '%$search%'");
		$hasil['draw'] = $draw;
		goto output;

		output:
		return $hasil;
	}

	public function update($params)
	{
		$client_token = $params['client_token'];
		$id = $params['id'];
		$nama = $params['nama'];
		$penerima_nama = $params['penerima_nama'];
		$penerima_telepon = $params['penerima_telepon'];
		$provinsi = $params['provinsi'];
		$kabupaten = $params['kabupaten'];
		$kecamatan = $params['kecamatan'];
		$alamat = $params['alamat'];

		if (empty($client_token)) {
			$hasil = array(
				'Error' => true,
				'Message' => "Parameter 'client_token' tidak diset."
			);
			goto output;
		}else if (empty($id)) {
			$hasil = array(
				'Error' => true,
				'Message' => "Alamat pengiriman belum dipilih."
			);
			goto output;
		}else if (empty($nama)) {
			$hasil = array(
				'Error' => true,
				'Message' => "Nama belum diisi."
			);
			goto output;
		}else if (empty($penerima_nama)) {
			$hasil = array(
				'Error' => true,
				'Message' => "Nama penerima belum diisi."
			);
			goto output;
		}else if (empty($penerima_telepon)) {
			$hasil = array(
				'Error' => true,
				'Message' => "No. Telepon penerima belum diisi."
			);
			goto output;
		}else if (empty($provinsi)) {
			$hasil = array(
				'Error' => true,
				'Message' => "Provinsi belum dipilih."
			);
			goto output;
		}else if (empty($kabupaten)) {
			$hasil = array(
				'Error' => true,
				'Message' => "Kabupaten belum dipilih."
			);
			goto output;
		}else if (empty($kecamatan)) {
			$hasil = array(
				'Error' => true,
				'Message' => "Kecamatan belum diisi."
			);
			goto output;
		}else if (empty($alamat)) {
			$hasil = array(
				'Error' => true,
				'Message' => "Alamat belum diisi."
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

			$cek_data = $this->db->query("
				SELECT
					id
				FROM
					$this->tabel
				WHERE
					user_id = '$user_id'
			");
			if ($cek_data->num_rows() == 1) {

				foreach ($cek_data->result_array() as $key) {
					if ($key['id'] != $id) {
						$hasil = array(
							'Error' => true,
							'Message' => "Data tidak ditemukan."
						);
						goto output;
					}
				}
			}

			$this->db->update($this->tabel, array(
				'nama' => $nama,
				'penerima_nama' => $penerima_nama,
				'penerima_no_telepon' => $penerima_telepon,
				'provinsi_id' => $provinsi,
				'kabupaten_id' => $kabupaten,
				'kecamatan_id' => $kecamatan,
				'alamat' => $alamat
			), array(
				'user_id' => $user_id,
				'id' => $id
			));

			$hasil = array(
				'Error' => false,
				'Message' => "Data berhasil diperbarui."
			);
			goto output;
		}

		output:
		return $hasil;
	}

	public function delete($params)
	{
		$client_token = $params['client_token'];
		$id = $params['id'];

		if (empty($client_token)) {
			$hasil = array(
				'Error' => true,
				'Message' => "Parameter 'client_token' tidak diset."
			);
			goto output;
		}else if (empty($id)) {
			$hasil = array(
				'Error' => true,
				'Message' => "Alamat pengiriman belum dipilih."
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

			$cek_data = $this->db->query("
				SELECT
					id
				FROM
					$this->tabel
				WHERE
					id = '$id' AND
					user_id = '$user_id'
			")->num_rows();

			if ($cek_data == 0) {
				$hasil = array(
					'Error' => true,
					'Message' => "Data tidak ditemukan."
				);
				goto output;
			}

			$this->db->delete($this->tabel, array(
				'user_id' => $user_id,
				'id' => $id
			));

			$hasil = array(
				'Error' => false,
				'Message' => "Data berhasil dihapus."
			);
			goto output;
		}

		output:
		return $hasil;
	}

	public function set_utama($params)
	{
		$client_token = $params['client_token'];
		$id = $params['id'];

		if (empty($client_token)) {
			$hasil = array(
				'Error' => true,
				'Message' => "Parameter 'client_token' tidak diset."
			);
			goto output;
		}else if (empty($id)) {
			$hasil = array(
				'Error' => true,
				'Message' => "Alamat pengiriman belum dipilih."
			);
			goto output;
		}

		$user_id = $this->get_user_id($client_token);

		if ($user_id == null) {
			$hasil = array(
				'Error' => true,
				'Message' => "User tidak ditemukan."
			);
			goto output;
		}

		$cek_data = $this->db->query("
			SELECT
				id
			FROM
				$this->tabel
			WHERE
				id = '$id' AND
				user_id = '$user_id'
		")->num_rows();
		if ($cek_data == 0) {
			$hasil = array(
				'Error' => true,
				'Message' => "Data tidak ditemukan."
			);
			goto output;
		}

		$this->db->update($this->tabel, array(
			'is_utama' => '0'
		), array(
			'user_id' => $user_id,
		));

		$this->db->update($this->tabel, array(
			'is_utama' => '1'
		), array(
			'user_id' => $user_id,
			'id' => $id
		));

		$hasil = array(
			'Error' => false,
			'Message' => "Alamat berhasil diset sebagai utama."
		);
		goto output;

		output:
		return $hasil;
	}

}

/* End of file M_Alamat_pengiriman.php */
/* Location: ./application/models/M_Alamat_pengiriman.php */