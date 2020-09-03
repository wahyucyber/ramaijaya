<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_Product extends MY_Model {

	protected $tabel = 'mst_produk';

	protected $tabel_foto = 'mst_produk_foto';

	protected $tabel_toko = 'mst_toko';

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

		$toko_id = $params['toko_id'];
		$status = $params['status'];
		$verifikasi = $params['verifikasi'];

		$limit = ($start != "" && !empty($length)) ? "LIMIT $start, $length":"";
		$where = "WHERE $this->tabel.nama_produk LIKE '%$search%'";

		(!empty($toko_id)) ? $where .= " AND $this->tabel.toko_id = '$toko_id'":"";
		($status != "") ? $where .= " AND $this->tabel.status = '$status'":"";
		($verifikasi != "") ? $where .= " AND $this->tabel.verifikasi = '$verifikasi'":"";

		$get_produk = $this->db->query("
			SELECT
				$this->tabel.id,
				$this->tabel.toko_id,
				$this->tabel_toko.nama_toko AS toko_nama,
				$this->tabel_toko.slug AS toko_slug,
				$this->tabel.nama_produk,
				$this->tabel.harga,
				$this->tabel.diskon,
				$this->tabel.berat,
				$this->tabel.stok,
				$this->tabel.status,
				$this->tabel.verifikasi,
				$this->tabel.catatan_diblokir,
				$this->tabel.slug,
				$this->tabel.created_at,
				$this->tabel.updated_at
			FROM
				$this->tabel
				LEFT JOIN $this->tabel_toko ON $this->tabel_toko.id = $this->tabel.toko_id
			$where
			ORDER BY $this->tabel.id DESC
			$limit
		")->result_array();

		$no = 0;
		$hasil['Error'] = false;
		$hasil['Message'] = "success.";
		$hasil['Data'] = array();
		foreach ($get_produk as $key) {
			if ($key['status'] == 1) {
				$status = "Aktif";
			}else if ($key['status'] == 0) {
				$status = "Tidak aktif";
			}

			if ($key['verifikasi'] == 1) {
				$verifikasi = "Ter-verifikasi";
			}else if ($key['verifikasi'] == 0) {
				$verifikasi = "Tidak ter-verifikasi";
			}

			$hasil['Data'][$no++] = array(
				'id' => $key['id'],
				'toko_id' => $key['toko_id'],
				'toko_nama' => $key['toko_nama'],
				'toko_slug' => $key['toko_slug'],
				'nama_produk' => $key['nama_produk'],
				'harga' => $key['harga'],
				'diskon' => $key['diskon'],
				'harga_diskon' => $key['harga'] - (($key['diskon']/100)*$key['harga']),
				'berat' => $key['berat'],
				'stok' => $key['stok'],
				'status' => $status,
				'verifikasi' => $verifikasi,
				'catatan_diblokir' => $key['catatan_diblokir'],
				'slug' => $key['slug'],
				'created_at' => $key['created_at'],
				'updated_at' => $key['updated_at'],
			);
		}
		$hasil['recordsTotal'] = $this->recordsTotal($this->tabel);
		$hasil['recordsFiltered'] = $this->recordsFiltered($this->tabel, 'id', "nama_produk LIKE '%$search%'");
		$hasil['draw'] = $draw;
		goto output;

		output:
		return $hasil;
	}

	public function set_verifikasi($params)
	{
		$id = $params['id'];

		if (empty($id)) {
			$hasil = array(
				'Error' => true,
				'Message' => "Parameter 'id' tidak diset."
			);
			goto output;
		}else {
			$cek_produk = $this->db->query("
				SELECT
					id
				FROM
					$this->tabel
				WHERE
					id = '$id'
			")->num_rows();

			if ($cek_produk == 0) {
				$hasil = array(
					'Error' => true,
					'Message' => "Produk tidak ditemukan."
				);
				goto output;
			}

			$this->db->update($this->tabel, array(
				'verifikasi' => '1',
				'catatan_diblokir' => null
			), array(
				'id' => $id
			));

			$hasil = array(
				'Error' => false,
				'Message' => "Produk berhasil di verifikasi."
			);
			goto output;
		}

		output:
		return $hasil;
	}

	public function set_nonverifikasi($params)
	{
		$id = $params['id'];
		$catatan = $params['catatan'];

		if (empty($id)) {
			$hasil = array(
				'Error' => true,
				'Message' => "Parameter 'id' tidak diset."
			);
			goto output;
		}else if (empty($catatan)) {
			$hasil = array(
				'Error' => true,
				'Message' => "Catatan tidak boleh kosong"
			);
			goto output;
		}else {
			$cek_produk = $this->db->query("
				SELECT
					id
				FROM
					$this->tabel
				WHERE
					id = '$id'
			")->num_rows();

			if ($cek_produk == 0) {
				$hasil = array(
					'Error' => true,
					'Message' => "Produk tidak ditemukan."
				);
				goto output;
			}

			$this->db->update($this->tabel, array(
				'verifikasi' => '0',
				'catatan_diblokir' => $catatan
			), array(
				'id' => $id
			));

			$hasil = array(
				'Error' => false,
				'Message' => "Produk berhasil di Tidak ter-verifikasi."
			);
			goto output;
		}

		output:
		return $hasil;
	}

}

/* End of file M_Product.php */
/* Location: ./application/models/M_Product.php */