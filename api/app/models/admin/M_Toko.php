<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_Toko extends MY_Model {

	protected $tabel = 'mst_toko';

	protected $tabel_provinsi = 'mst_provinsi';

	protected $tabel_kabupaten = 'mst_kabupaten';

	protected $tabel_kecamatan = 'mst_kecamatan';

	protected $tabel_user = 'mst_user';

	public function __construct()
	{
		parent::__construct();
	}

	public function index($params)
	{
		$start = $params['start'];
		$length = $params['length'];
		$draw = $params['draw'];
		$search = $params['search']['value'];
		$status = $params['status'];

		$limit = ($start != "" && !empty($length)) ? "LIMIT $start, $length":"";
		$where = "WHERE $this->tabel.nama_toko LIKE '%$search%'";
		($status != "") ? $where .= " AND $this->tabel.status = '$status'":"";

		$get_toko = $this->db->query("
			SELECT
				$this->tabel.id,
				CONCAT('".base_url('')."', $this->tabel.logo) AS logo,
				$this->tabel.nama_toko,
				$this->tabel.provinsi_id,
				$this->tabel_provinsi.nama AS provinsi_nama,
				$this->tabel.kabupaten_id,
				CONCAT($this->tabel_kabupaten.type, ' ', $this->tabel_kabupaten.nama) AS kabupaten_nama,
				$this->tabel.kecamatan_id,
				$this->tabel_kecamatan.nama AS kecamatan_nama,
				$this->tabel.kode_pos,
				$this->tabel.status,
				$this->tabel.diblokir,
				$this->tabel.catatan_diblokir
			FROM
				$this->tabel
				LEFT JOIN $this->tabel_provinsi ON $this->tabel_provinsi.id = $this->tabel.provinsi_id
				LEFT JOIN $this->tabel_kabupaten ON $this->tabel_kabupaten.id = $this->tabel.kabupaten_id
				LEFT JOIN $this->tabel_kecamatan ON $this->tabel_kecamatan.id = $this->tabel.kecamatan_id
			$where
			ORDER BY $this->tabel.id DESC
			$limit
		")->result_array();
		$no = 0;
		$hasil['Error'] = false;
		$hasil['Message'] = "success.";
		$hasil['Data'] = array();
		foreach ($get_toko as $key) {
			if ($key['status'] == 0) {
				$status = "Tidak aktif";
			}else if($key['status'] == 1) {
				$status = "Aktif";
			}
			$hasil['Data'][$no++] = array(
				'id' => $key['id'],
				'logo' => $key['logo'],
				'nama_toko' => $key['nama_toko'],
				'provinsi_id' => $key['provinsi_id'],
				'provinsi_nama' => $key['provinsi_nama'],
				'kabupaten_id' => $key['kabupaten_id'],
				'kabupaten_nama' => $key['kabupaten_nama'],
				'kecamatan_id' => $key['kecamatan_id'],
				'kecamatan_nama' => $key['kecamatan_nama'],
				'kode_pos' => $key['kode_pos'],
				'status' => $status,
				'diblokir' => $key['diblokir'],
				'catatan_diblokir' => $key['catatan_diblokir']
			);
		}
		$hasil['recordsTotal'] = $this->recordsTotal($this->tabel);
		$hasil['recordsFiltered'] = $this->recordsFiltered($this->tabel, 'id', "$this->tabel.nama_toko LIKE '%$search%'");
		$hasil['draw'] = $draw;
		goto output;

		output:
		return $hasil;
	}

	public function set_aktif($params)
	{
		$toko_id = $params['toko_id'];

		if (empty($toko_id)) {
			$hasil = array(
				'Error' => true,
				'Message' => "Parameter 'toko_id' tidak diset."
			);
			goto output;
		}else{
			$cek_toko = $this->db->query("
				SELECT
					id
				FROM
					$this->tabel
				WHERE
					id = '$toko_id'
			")->num_rows();
			if ($cek_toko == 0) {
				$hasil = array(
					'Error' => true,
					'Message' => "Toko tidak ditemukan."
				);
				goto output;
			}

			$this->db->update($this->tabel, array(
				'status' => '1'
			), array(
				'id' => $toko_id
			));

			$hasil = array(
				'Error' => false,
				'Message' => "Toko berhasil diaktifkan."
			);
			goto output;
		}

		output:
		return $hasil;
	}

	public function set_nonaktif($params)
	{
		$toko_id = $params['toko_id'];

		if (empty($toko_id)) {
			$hasil = array(
				'Error' => true,
				'Message' => "Parameter 'toko_id' tidak diset."
			);
			goto output;
		}else{
			$cek_toko = $this->db->query("
				SELECT
					id
				FROM
					$this->tabel
				WHERE
					id = '$toko_id'
			")->num_rows();
			if ($cek_toko == 0) {
				$hasil = array(
					'Error' => true,
					'Message' => "Toko tidak ditemukan."
				);
				goto output;
			}

			$this->db->update($this->tabel, array(
				'status' => '0'
			), array(
				'id' => $toko_id
			));

			$hasil = array(
				'Error' => false,
				'Message' => "Toko berhasil dinonaktifkan."
			);
			goto output;
		}

		output:
		return $hasil;
	}
	public function blokir($params)
	{
		$toko_id = isset($params['toko_id'])? $params['toko_id'] : '';
		$catatan = isset($params['catatan'])? $params['catatan'] : '';

		if (empty($toko_id)) {
			$result['Error'] = true;
			$result['Message'] = "Parameter toko_id tidak diset";
			goto output;
		}else if(empty($catatan)) {
			$result['Error'] = true;
			$result['Message'] = "Catatan tidak boleh kosong";
			goto output;
		}

		$toko = $this->db->query("SELECT
										id
									FROM
										$this->tabel
									WHERE
										id = '$toko_id'")->row_array();
		if (!$toko) {
			$result['Error'] = true;
			$result['Message'] = "Toko tidak ditemukan";
			goto output;
		}

		$update = $this->db->update($this->tabel,['diblokir' => 1, 'catatan_diblokir' => $catatan],['id' => $toko_id]);
		if ($update) {
			$result['Error'] = false;
			$result['Message'] = "Berhasil memblokir toko";
			goto output;
		}
		$result['Error'] = true;
		$result['Message'] = "Gagal memblokir toko";
		goto output;
		output:
		return $result;
	}

	public function buka_blokir($params)
	{
		$toko_id = isset($params['toko_id'])? $params['toko_id'] : '';

		if (empty($toko_id)) {
			$result['Error'] = true;
			$result['Message'] = "Parameter toko_id tidak diset";
			goto output;
		}

		$toko = $this->db->query("SELECT
										id
									FROM
										$this->tabel
									WHERE
										id = '$toko_id'")->row_array();
		if (!$toko) {
			$result['Error'] = true;
			$result['Message'] = "Toko tidak ditemukan";
			goto output;
		}

		$update = $this->db->update($this->tabel,['diblokir' => 0, 'catatan_diblokir' => null],['id' => $toko_id]);
		if ($update) {
			$result['Error'] = false;
			$result['Message'] = "Berhasil membuka blokir toko";
			goto output;
		}
		$result['Error'] = true;
		$result['Message'] = "Gagal membuka blokir toko";
		goto output;
		output:
		return $result;
	}
}

/* End of file M_Toko.php */
/* Location: ./application/models/M_Toko.php */