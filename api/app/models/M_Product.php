<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Product extends MY_Model {

	protected $tabel = 'mst_produk';

	protected $tabel_produk_foto = 'mst_produk_foto';

	protected $tabel_toko = 'mst_toko';

	protected $tabel_toko_catatan = 'mst_toko_catatan';

	protected $tabel_produk_favorit = 'mst_produk_favorit';

	protected $tabel_user = 'mst_user';

	protected $tabel_kategori = 'mst_kategori';

	protected $tabel_provinsi = 'mst_provinsi';

	protected $tabel_kabupaten = 'mst_kabupaten';

	protected $tabel_kecamatan = 'mst_kecamatan';

	protected $tabel_ulasan = 'mst_produk_ulasan';

	protected $tabel_ulasan_foto = 'mst_produk_ulasan_foto';

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_Wishlist','wishlist');
		$this->load->model('user/M_Product_favorit', 'product_favorit');
		$this->load->model('user/M_Pembelian', 'pembelian');
	}

	private function produk_rating($produk_id)
	{
		$get_ulasan = $this->db->query("SELECT
											id
										FROM
											$this->tabel_ulasan
										WHERE
											produk_id = '$produk_id'");

		$jumlah_ulasan = $get_ulasan->num_rows();

		$get_rating = $this->db->query("
			SELECT
				SUM(rating) AS total_rating
			FROM
				$this->tabel_ulasan
			WHERE
				produk_id = '$produk_id'
		")->row_array();

		$jumlah_rating = ($get_rating['total_rating'] == null) ? 0 : $get_rating['total_rating'];

		if ($jumlah_ulasan == 0) {
			return 0;
		}else{
			return $jumlah_rating/$jumlah_ulasan;
		}
	}

	function all($params)
	{
		$client_token = isset($params['client_token'])? $params['client_token'] : '';
		$limit = isset($params['limit'])? $params['limit'] : 20;
		$user = null;

		$query_produk_favorit = '0 AS favorit,';

		if (!empty($client_token)) {
			$user = $this->db->query("SELECT
											id as id_user
										FROM
											$this->tabel_user
										WHERE
											api_token = '$client_token'")->row_array();
			if (!$user) {
				$result['Error'] = true;
				$result['Message'] = "Pengguna tidak ditemukan";
				goto output;
			}

			$user_id = $user['id_user'];

			$tabel_favorit = $this->tabel_produk_favorit;

			$query_produk_favorit = "(SELECT COUNT($tabel_favorit.id) FROM $tabel_favorit WHERE $tabel_favorit.produk_id = $this->tabel.id AND $tabel_favorit.user_id = '$user_id') AS favorit,";
		}

		$query = $this->db->query("SELECT
										$this->tabel.id as id_produk,
										$this->tabel.toko_id,
										$this->tabel_toko.slug as slug_toko,
										$this->tabel_toko.nama_toko,
										$this->tabel_toko.provinsi_id,
										$this->tabel_provinsi.nama as nama_provinsi,
										$this->tabel_toko.kabupaten_id,
										$this->tabel_kabupaten.nama as nama_kabupaten,
										$this->tabel_toko.kecamatan_id,
										$this->tabel_kecamatan.nama as nama_kecamatan,
										$this->tabel.sku_produk,
										$this->tabel.nama_produk,
										$this->tabel.keterangan,
										$this->tabel.harga,
										$this->tabel.diskon,
										$this->tabel.diskon_dari,
										$this->tabel.diskon_ke,
										$this->tabel.berat,
										$this->tabel.stok_awal,
										$this->tabel.stok,
										$this->tabel.kondisi,
										$this->tabel.min_beli,
										$this->tabel.asuransi,
										$this->tabel.preorder,
										$this->tabel.lama_preorder,
										$this->tabel.waktu_preorder,
										$this->tabel.etalase_id,
										$this->tabel.kategori_id,
										$this->tabel_kategori.nama_kategori,
										$this->tabel.slug as slug_produk,
										$query_produk_favorit
										$this->tabel.status as status_produk
									FROM
										$this->tabel
									LEFT JOIN
										$this->tabel_kategori
									ON
										$this->tabel.kategori_id = $this->tabel_kategori.id
									LEFT JOIN
										$this->tabel_toko
									ON
										$this->tabel.toko_id = $this->tabel_toko.id
									LEFT JOIN
										$this->tabel_provinsi
									ON
										$this->tabel_toko.provinsi_id = $this->tabel_provinsi.id
									LEFT JOIN
										$this->tabel_kabupaten
									ON
										$this->tabel_toko.kabupaten_id = $this->tabel_kabupaten.id
									LEFT JOIN
										$this->tabel_kecamatan
									ON
										$this->tabel_toko.kecamatan_id = $this->tabel_kecamatan.id
									WHERE
										$this->tabel.status = 1
									AND
										$this->tabel.verifikasi = 1
									AND
										$this->tabel_toko.status = 1
									ORDER BY $this->tabel.id DESC
									LIMIT 0, 10
									");
		if ($query->num_rows() > 0) {

			$no = 0;

			foreach ($query->result_array() as $key) {
				if($key['diskon_dari'] != null && $key['diskon_ke'] != null) {
					if (strtotime(date('Y-m-d')) >= strtotime($key['diskon_dari']) && strtotime(date('Y-m-d')) <= strtotime($key['diskon_ke'])) {
						$diskon = $key['diskon'];
						$harga_diskon = ceil($key['harga'] - (($key['diskon']/100)*$key['harga']));
					}else {
						$diskon = 0;
						$harga_diskon = 0;
					}
				}else {
					$diskon = $key['diskon'];
					$harga_diskon = ceil($key['harga'] - (($key['diskon']/100)*$key['harga']));
				}

				$result['Error'] = false;
				$result['Message'] = null;
				$result['Data'][$no++] = [
					'id_produk' => $key['id_produk'],
					'toko_id' => $key['toko_id'],
					'nama_toko' => $key['nama_toko'],
					'provinsi_id' => $key['provinsi_id'],
					'nama_provinsi' => $key['nama_provinsi'],
					'kabupaten_id' => $key['kabupaten_id'],
					'nama_kabupaten' => $key['nama_kabupaten'],
					'kecamatan_id' => $key['kecamatan_id'],
					'nama_kecamatan' => $key['nama_kecamatan'],
					'slug_toko' => $key['slug_toko'],
					'foto_produk' => $this->foto_produk($key['id_produk'])[0]['foto'],
					'sku_produk' => $key['sku_produk'],
					'nama_produk' => $key['nama_produk'],
					'keterangan' => $key['keterangan'],
					'harga' => $key['harga'],
					'diskon' => $diskon,
					'harga_diskon' => $harga_diskon,
					'berat' => $key['berat'],
					'stok_awal' => $key['stok_awal'],
					'rating' => $this->produk_rating($key['id_produk']),
					'stok' => $key['stok'],
					'kondisi' => $key['kondisi'],
					'min_beli' => $key['min_beli'],
					'asuransi' => $key['asuransi'],
					'preorder' => $key['preorder'],
					'lama_preorder' => $key['lama_preorder'],
					'waktu_preorder' => $key['waktu_preorder'],
					'etalase_id' => $key['etalase_id'],
					'kategori_id' => $key['kategori_id'],
					'nama_kategori' => $key['nama_kategori'],
					'slug_produk' => $key['slug_produk'],
					'status_produk' => $key['status_produk'],
					'favorit' => $key['favorit'],
					'wishlist' => $this->wishlist->get($user['id_user'],$key['id_produk'])
				];
			}
			goto output;

		}
		$result['Error'] = true;
		$result['Message'] = "Produk tidak ditemukann";
		goto output;
		output:
		return $result;


	}

	function list($params)
	{
		$client_token = isset($params['client_token'])? $params['client_token'] : '';
		$limit = isset($params['limit'])? $params['limit'] : 35;
		$user = null;

		$query_produk_favorit = '0 AS favorit,';

		if (!empty($client_token)) {
			$user = $this->db->query("SELECT
											id as id_user
										FROM
											$this->tabel_user
										WHERE
											api_token = '$client_token'")->row_array();
			if (!$user) {
				$result['Error'] = true;
				$result['Message'] = "Pengguna tidak ditemukan";
				goto output;
			}

			$user_id = $user['id_user'];

			$tabel_favorit = $this->tabel_produk_favorit;

			$query_produk_favorit = "(SELECT COUNT($tabel_favorit.id) FROM $tabel_favorit WHERE $tabel_favorit.produk_id = $this->tabel.id AND $tabel_favorit.user_id = '$user_id') AS favorit,";
		}

		$filter = empty($params['recent'])? "" : " AND nama_produk LIKE '%$recent%'";

		$query = $this->db->query("SELECT
										$this->tabel.id as id_produk,
										$this->tabel.toko_id,
										$this->tabel_toko.slug as slug_toko,
										$this->tabel_toko.nama_toko,
										$this->tabel_toko.provinsi_id,
										$this->tabel_provinsi.nama as nama_provinsi,
										$this->tabel_toko.kabupaten_id,
										$this->tabel_kabupaten.nama as nama_kabupaten,
										$this->tabel_toko.kecamatan_id,
										$this->tabel_kecamatan.nama as nama_kecamatan,
										$this->tabel.sku_produk,
										$this->tabel.nama_produk,
										$this->tabel.keterangan,
										$this->tabel.harga,
										$this->tabel.diskon,
										$this->tabel.berat,
										$this->tabel.stok_awal,
										$this->tabel.stok,
										$this->tabel.kondisi,
										$this->tabel.min_beli,
										$this->tabel.asuransi,
										$this->tabel.preorder,
										$this->tabel.lama_preorder,
										$this->tabel.waktu_preorder,
										$query_produk_favorit
										$this->tabel.etalase_id,
										$this->tabel.kategori_id,
										$this->tabel_kategori.nama_kategori,
										$this->tabel.slug as slug_produk,
										$this->tabel.status as status_produk
									FROM
										$this->tabel
									LEFT JOIN
										$this->tabel_kategori
									ON
										$this->tabel.kategori_id = $this->tabel_kategori.id
									LEFT JOIN
										$this->tabel_toko
									ON
										$this->tabel.toko_id = $this->tabel_toko.id
									LEFT JOIN
										$this->tabel_provinsi
									ON
										$this->tabel_toko.provinsi_id = $this->tabel_provinsi.id
									LEFT JOIN
										$this->tabel_kabupaten
									ON
										$this->tabel_toko.kabupaten_id = $this->tabel_kabupaten.id
									LEFT JOIN
										$this->tabel_kecamatan
									ON
										$this->tabel_toko.kecamatan_id = $this->tabel_kecamatan.id
									WHERE
										$this->tabel.status = 1
									AND
										$this->tabel.verifikasi = 1
									$filter");
		if ($query->num_rows() > 0) {
			
			$config['jumlah_data'] = $query->num_rows();
			$config['limit'] = $limit;
			$config['page']	= empty($params['page'])? null : $params['page'];

			$pagination = $this->query_pagination($config);

			$result['Error'] = true;
			$result['Message'] = "Produk tidak ditemukann";

			$produk = $this->db->query("SELECT
											$this->tabel.id as id_produk,
											$this->tabel.toko_id,
											$this->tabel_toko.slug as slug_toko,
											$this->tabel_toko.nama_toko,
											$this->tabel_toko.provinsi_id,
											$this->tabel_provinsi.nama as nama_provinsi,
											$this->tabel_toko.kabupaten_id,
											$this->tabel_kabupaten.nama as nama_kabupaten,
											$this->tabel_toko.kecamatan_id,
											$this->tabel_kecamatan.nama as nama_kecamatan,
											$this->tabel.sku_produk,
											$this->tabel.nama_produk,
											$this->tabel.keterangan,
											$this->tabel.harga,
											$this->tabel.diskon,
											$this->tabel.diskon_dari,
											$this->tabel.diskon_ke,
											$this->tabel.berat,
											$this->tabel.stok_awal,
											$this->tabel.stok,
											$this->tabel.kondisi,
											$this->tabel.min_beli,
											$this->tabel.asuransi,
											$this->tabel.preorder,
											$this->tabel.lama_preorder,
											$this->tabel.waktu_preorder,
											$this->tabel.etalase_id,
											$query_produk_favorit
											$this->tabel.kategori_id,
											$this->tabel_kategori.nama_kategori,
											$this->tabel.slug as slug_produk,
											$this->tabel.status as status_produk
										FROM
											$this->tabel
										LEFT JOIN
											$this->tabel_kategori
										ON
											$this->tabel.kategori_id = $this->tabel_kategori.id
										LEFT JOIN
											$this->tabel_toko
										ON
											$this->tabel.toko_id = $this->tabel_toko.id
										LEFT JOIN
											$this->tabel_provinsi
										ON
											$this->tabel_toko.provinsi_id = $this->tabel_provinsi.id
										LEFT JOIN
											$this->tabel_kabupaten
										ON
											$this->tabel_toko.kabupaten_id = $this->tabel_kabupaten.id
										LEFT JOIN
											$this->tabel_kecamatan
										ON
											$this->tabel_toko.kecamatan_id = $this->tabel_kecamatan.id
										WHERE
											$this->tabel.status = 1
										AND
											$this->tabel.verifikasi = 1
										$filter
										ORDER BY $this->tabel.dilihat DESC
										LIMIT
											$pagination[Data_ke],$limit
										");

			$no = 0;

			foreach ($produk->result_array() as $key) {
				if($key['diskon_dari'] != null && $key['diskon_ke'] != null) {
					if (strtotime(date('Y-m-d')) >= strtotime($key['diskon_dari']) && strtotime(date('Y-m-d')) <= strtotime($key['diskon_ke'])) {
						$diskon = $key['diskon'];
						$harga_diskon = ceil($key['harga'] - (($key['diskon']/100)*$key['harga']));
					}else {
						$diskon = 0;
						$harga_diskon = 0;
					}
				}else {
					$diskon = $key['diskon'];
					$harga_diskon = ceil($key['harga'] - (($key['diskon']/100)*$key['harga']));
				}

				$result['Error'] = false;
				$result['Message'] = null;
				$result['Data'][$no++] = [
					'id_produk' => $key['id_produk'],
					'toko_id' => $key['toko_id'],
					'nama_toko' => $key['nama_toko'],
					'provinsi_id' => $key['provinsi_id'],
					'nama_provinsi' => $key['nama_provinsi'],
					'kabupaten_id' => $key['kabupaten_id'],
					'nama_kabupaten' => $key['nama_kabupaten'],
					'kecamatan_id' => $key['kecamatan_id'],
					'nama_kecamatan' => $key['nama_kecamatan'],
					'slug_toko' => $key['slug_toko'],
					'foto_produk' => $this->foto_produk($key['id_produk'])[0]['foto'],
					'sku_produk' => $key['sku_produk'],
					'nama_produk' => $key['nama_produk'],
					'keterangan' => $key['keterangan'],
					'harga' => $key['harga'],
					'diskon' => $diskon,
					'harga_diskon' => $harga_diskon,
					'berat' => $key['berat'],
					'stok_awal' => $key['stok_awal'],
					'stok' => $key['stok'],
					'kondisi' => $key['kondisi'],
					'min_beli' => $key['min_beli'],
					'asuransi' => $key['asuransi'],
					'preorder' => $key['preorder'],
					'lama_preorder' => $key['lama_preorder'],
					'waktu_preorder' => $key['waktu_preorder'],
					'etalase_id' => $key['etalase_id'],
					'kategori_id' => $key['kategori_id'],
					'nama_kategori' => $key['nama_kategori'],
					'slug_produk' => $key['slug_produk'],
					'status_produk' => $key['status_produk'],
					'favorit' => $key['favorit'],
					'rating' => $this->produk_rating($key['id_produk']),
					'wishlist' => $this->wishlist->get($user['id_user'],$key['id_produk'])
				];
				$result['Pagination'] = $pagination;
			}
			goto output;

		}
		$result['Error'] = true;
		$result['Message'] = "Produk tidak ditemukann";
		goto output;
		output:
		return $result;

	}

	private function foto_produk($produk_id)
	{
		$query = $this->db->query("SELECT
										id as id_foto,
										CONCAT('".base_url('')."', '', foto) AS foto
									FROM
										$this->tabel_produk_foto
									WHERE
										produk_id = $produk_id");
		$result = null;
		if ($query->num_rows() > 0) {
			$no = 0;
			foreach($query->result_array() as $key) {
				$result[$no++] = $key;
			}
		}
		return $result;
	}

	private function _toko_catatan($toko_id)
	{
		$get_catatan = $this->db->query("
			SELECT
				id,
				judul,
				teks,
				created_at,
				updated_at
			FROM
				$this->tabel_toko_catatan
			WHERE
				toko_id = '$toko_id'
		")->result_array();
		$hasil = array();
		$no = 0;
		foreach ($get_catatan as $key) {
			$hasil[$no++] = $key;
		}

		return $hasil;
	}

	public function detail($params)
	{
		$client_token = isset($params['client_token'])? $params['client_token'] : '';
		$produk_nama = $params['produk_nama'];
		$toko_nama = $params['toko_nama'];

		if (empty($produk_nama)) {
			$hasil = array(
				'Error' => true,
				'Message' => "Parameter 'produk_nama' tidak diset."
			);
			goto output;
		}else if (empty($toko_nama)){
			$hasil = array(
				'Error' => true,
				'Message' => "Parameter 'toko_nama' tidak diset."
			);
			goto output;
		}else{
			$user = null;

			$query_produk_favorit = '0 AS favorit,';

			if (!empty($client_token)) {
				$user = $this->db->query("SELECT
												id as id_user
											FROM
												$this->tabel_user
											WHERE
												api_token = '$client_token'")->row_array();
				if (!$user) {
					$result['Error'] = true;
					$result['Message'] = "Pengguna tidak ditemukan";
					goto output;
				}

				$tabel_favorit = $this->tabel_produk_favorit;

				$query_produk_favorit = "(SELECT COUNT($tabel_favorit.id) FROM $tabel_favorit WHERE $tabel_favorit.produk_id = $this->tabel.id AND $tabel_favorit.user_id = '$user[id_user]') AS favorit,";
			}

			$get_toko_id = $this->db->query("
				SELECT
					id
				FROM
					$this->tabel_toko
				WHERE
					slug = '$toko_nama'
			");

			if ($get_toko_id->num_rows() == 0) {
				$hasil = array(
					'Error' => true,
					'Message' => "Toko tidak ditemukan."
				);
				goto output;
			}

			foreach ($get_toko_id->result_array() as $key) {
				$toko_id = $key['id'];
			}

			$get_produk_id = $this->db->query("
				SELECT
					id,
					dilihat
				FROM
					$this->tabel
				WHERE
					slug = '$produk_nama' AND
					toko_id = '$toko_id'
			");

			if ($get_produk_id->num_rows() == 0) {
				$hasil = array(
					'Error' => true,
					'Message' => "Produk tidak ditemukan."
				);
				goto output;
			}

			foreach ($get_produk_id->result_array() as $key) {
				$produk_id = $key['id'];
				$dilihat = $key['dilihat'] + 1;
			}

			$this->db->update('mst_produk', array(
				'dilihat' => $dilihat
			), array(
				'id' => $produk_id
			));

			$get_produk = $this->db->query("
				SELECT
					$this->tabel.id,
					$this->tabel.toko_id,
					$this->tabel_toko.logo AS toko_logo,
					$this->tabel_toko.banner AS toko_banner,
					$this->tabel_toko.nama_toko AS toko_nama,
					$this->tabel_toko.slug AS toko_slug,
					$this->tabel_toko.deskripsi AS toko_deskripsi,
					$this->tabel_toko.provinsi_id AS toko_provinsi_id,
					$this->tabel_provinsi.nama AS toko_provinsi_nama,
					$this->tabel_toko.kabupaten_id AS toko_kabupaten_id,
					CONCAT($this->tabel_kabupaten.type, ' ', $this->tabel_kabupaten.nama) AS toko_kabupaten_nama,
					$this->tabel_toko.kecamatan_id AS toko_kecamatan_id,
					$this->tabel_kecamatan.nama AS toko_kecamatan_nama,
					$this->tabel.sku_produk,
					$this->tabel.nama_produk,
					$this->tabel.keterangan,
					$this->tabel.harga,
					$this->tabel.berat,
					$this->tabel.stok,
					$this->tabel.kondisi,
					$this->tabel.dilihat,
					$this->tabel.min_beli,
					$this->tabel.kategori_id,
					$this->tabel.diskon,
					$this->tabel.diskon_dari,
					$this->tabel.diskon_ke,
					$query_produk_favorit
					$this->tabel_kategori.nama_kategori,
					$this->tabel.created_at,
					$this->tabel.updated_at
				FROM
					$this->tabel
					LEFT JOIN $this->tabel_toko ON $this->tabel_toko.id = $this->tabel.toko_id
					LEFT JOIN $this->tabel_provinsi ON $this->tabel_provinsi.id = $this->tabel_toko.provinsi_id
					LEFT JOIN $this->tabel_kabupaten ON $this->tabel_kabupaten.id = $this->tabel_toko.kabupaten_id
					LEFT JOIN $this->tabel_kecamatan ON $this->tabel_kecamatan.id = $this->tabel_toko.kecamatan_id
					LEFT JOIN $this->tabel_kategori ON $this->tabel_kategori.id = $this->tabel.kategori_id
				WHERE
					$this->tabel.toko_id = '$toko_id' AND
					$this->tabel.id = '$produk_id'
			");
			if ($get_produk->num_rows() == 0) {
				$hasil = array(
					'Error' => true,
					'Message' => "Produk tidak ditemukan."
				);
				goto output;
			}

			$hasil['Error'] = false;
			$hasil['Message'] = "success.";
			$no = 0;
			foreach ($get_produk->result_array() as $key) {
				if($key['diskon_dari'] != null && $key['diskon_ke'] != null) {
					if (strtotime(date('Y-m-d')) >= strtotime($key['diskon_dari']) && strtotime(date('Y-m-d')) <= strtotime($key['diskon_ke'])) {
						$diskon = $key['diskon'];
						$harga_diskon = ceil($key['harga'] - (($key['diskon']/100)*$key['harga']));
					}else {
						$diskon = 0;
						$harga_diskon = 0;
					}
				}else {
					$diskon = $key['diskon'];
					$harga_diskon = ceil($key['harga'] - (($key['diskon']/100)*$key['harga']));
				}

				$hasil['Data'][$no++] = array(
					'id' => $key['id'],
					'toko_id' => $key['toko_id'],
					'toko_logo' => $key['toko_logo'],
					'toko_banner' => $key['toko_banner'],
					'toko_nama' => $key['toko_nama'],
					'toko_slug' => $key['toko_slug'],
					'toko_deskripsi' => $key['toko_deskripsi'],
					'toko_provinsi_id' => $key['toko_provinsi_id'],
					'toko_provinsi_nama' => $key['toko_provinsi_nama'],
					'toko_kabupaten_id' => $key['toko_kabupaten_id'],
					'toko_kabupaten_nama' => $key['toko_kabupaten_nama'],
					'toko_kecamatan_id' => $key['toko_kecamatan_id'],
					'toko_kecamatan_nama' => $key['toko_kecamatan_nama'],
					'toko_catatan' => $this->_toko_catatan($key['toko_id']),
					'sku_produk' => $key['sku_produk'],
					'foto' => $this->foto_produk($key['id']),
					'nama' => $key['nama_produk'],
					'keterangan' => $key['keterangan'],
					'harga' => $key['harga'],
					'diskon' => $diskon,
					'harga_diskon' => $harga_diskon,
					'berat' => $key['berat'],
					'stok' => $key['stok'],
					'favorit' => $key['favorit'],
					'kondisi' => ($key['kondisi'] == 1) ? "Baru" : "Bekas",
					'dilihat' => $key['dilihat'],
					'minimal_beli' => $key['min_beli'],
					'kategori_id' => $key['kategori_id'],
					'rating' => $this->produk_rating($key['id']),
					'jumlah_ulasan' => $this->get_jumlah_ulasan($key['id']),
					'kategori_nama' => $key['nama_kategori'],
					'created_at' => $key['created_at'],
					'updated_at' => $key['updated_at']
				);
			}
			goto output;
		}

		output:
		return $hasil;
	}

	private function get_jumlah_ulasan($produk_id)
	{
		$get_ulasan = $this->db->query("SELECT
                                            $this->tabel_ulasan.id,
                                            $this->tabel_ulasan.user_id,
                                            $this->tabel_ulasan.produk_id,
                                            $this->tabel.nama_produk,
                                            $this->tabel_user.nama AS user_nama,
                                            $this->tabel_ulasan.rating,
                                            $this->tabel_ulasan.ulasan,
                                            $this->tabel_ulasan.created_at,
                                            $this->tabel_ulasan.updated_at
                                        FROM
                                            $this->tabel_ulasan
                                        LEFT JOIN
                                            $this->tabel_user
                                            ON
                                            $this->tabel_ulasan.user_id = $this->tabel_user.id
                                        LEFT JOIN
                                            $this->tabel
                                            ON
                                            $this->tabel_ulasan.produk_id = $this->tabel.id
                                        WHERE
                                            $this->tabel_ulasan.produk_id = '$produk_id'");

		$jumlah_ulasan = $get_ulasan->num_rows();
		return $jumlah_ulasan;
	}

	public function search($params)
	{
		$q = $params['q'];
		$st = $params['st'];
		$kategori_id = $params['kategori_id'];
		$filter = $params['filter'];
		$provinsi_id = $params['provinsi_id'];
		$kabupaten_id = $params['kabupaten_id'];
		$kecamatan_id = $params['kecamatan_id'];

		if (empty($st)) {
			$hasil = array(
				'Error' => true,
				'Message' => "Parameter 'st' tidak diset."
			);
			goto output;
		}else{
			if ($st == "produk" || $st == "katalog") {
				$where = '';
				$filter_order = "";

				if (!empty($kategori_id)) {
					$cek_kategori = $this->db->query("
						SELECT
							kategori_id
						FROM
							$this->tabel_kategori
						WHERE
							id = '$kategori_id'
					")->row_array();

					if ($cek_kategori['kategori_id'] == 0) {
						$where .= " AND $this->tabel_kategori.id = '$kategori_id'";
					}else{
						$where .= " AND $this->tabel_kategori.id = '$kategori_id'";
					}
				}

				if (isset($filter)) {
					if ($filter == "Terbaru") {
						$filter_order = "ORDER BY $this->tabel.id DESC";
					}else if ($filter == "Banyak Dilihat") {
						$filter_order = "ORDER BY $this->tabel.dilihat DESC";
					}else if ($filter == "Harga Tertinggi") {
						$filter_order = "ORDER BY $this->tabel.harga DESC";
					}else if ($filter == "Harga Terendah") {
						$filter_order = "ORDER BY $this->tabel.harga ASC";
					}
				}

				(!empty($provinsi_id)) ? $where .= " AND $this->tabel_toko.provinsi_id = '$provinsi_id'":"";
				(!empty($kabupaten_id)) ? $where .= " AND $this->tabel_toko.kabupaten_id = '$kabupaten_id'":"";
				(!empty($kecamatan_id)) ? $where .= " AND $this->tabel_toko.kecamatan_id = '$kecamatan_id'":"";

				$limit = 10;

				$query = $this->db->query("
					SELECT
						$this->tabel.id,
						$this->tabel.toko_id
					FROM
						$this->tabel_kategori
						LEFT JOIN $this->tabel ON $this->tabel.kategori_id = $this->tabel_kategori.id
						LEFT JOIN $this->tabel_toko ON $this->tabel_toko.id = $this->tabel.toko_id
					WHERE
						CONCAT($this->tabel.nama_produk, ' ', $this->tabel_toko.nama_toko) LIKE '%$q%'
						$where
					$filter_order
				");

				$config['jumlah_data'] = $query->num_rows();
				$config['limit'] = $limit;
				$config['page']	= empty($params['page'])? null : $params['page'];

				$pagination = $this->query_pagination($config);

				$get_produk = $this->db->query("
					SELECT
						$this->tabel.id,
						$this->tabel.toko_id,
						$this->tabel_toko.logo AS toko_logo,
						$this->tabel_toko.banner AS toko_banner,
						$this->tabel_toko.slug AS toko_slug,
						$this->tabel_toko.nama_toko AS toko_nama,
						$this->tabel_toko.deskripsi AS toko_deskripsi,
						$this->tabel_toko.provinsi_id AS toko_provinsi_id,
						$this->tabel_provinsi.nama AS toko_provinsi_nama,
						$this->tabel_toko.kabupaten_id AS toko_kabupaten_id,
						CONCAT($this->tabel_kabupaten.type, ' ', $this->tabel_kabupaten.nama) AS toko_kabupaten_nama,
						$this->tabel_toko.kecamatan_id AS toko_kecamatan_id,
						$this->tabel_kecamatan.nama AS toko_kecamatan_nama,
						$this->tabel.sku_produk,
						$this->tabel.nama_produk,
						$this->tabel.keterangan,
						$this->tabel.harga,
						$this->tabel.diskon,
						$this->tabel.diskon_dari,
						$this->tabel.diskon_ke,
						$this->tabel.slug,
						$this->tabel.berat,
						$this->tabel.stok,
						$this->tabel.kondisi,
						$this->tabel.dilihat,
						$this->tabel.min_beli,
						$this->tabel.kategori_id,
						$this->tabel_kategori.nama_kategori,
						$this->tabel.created_at,
						$this->tabel.updated_at
					FROM
						$this->tabel_kategori
						LEFT JOIN $this->tabel ON $this->tabel.kategori_id = $this->tabel_kategori.id
						LEFT JOIN $this->tabel_toko ON $this->tabel_toko.id = $this->tabel.toko_id
						LEFT JOIN $this->tabel_provinsi ON $this->tabel_provinsi.id = $this->tabel_toko.provinsi_id
						LEFT JOIN $this->tabel_kabupaten ON $this->tabel_kabupaten.id = $this->tabel_toko.kabupaten_id
						LEFT JOIN $this->tabel_kecamatan ON $this->tabel_kecamatan.id = $this->tabel_toko.kecamatan_id
					WHERE
						CONCAT($this->tabel.nama_produk, ' ', $this->tabel_toko.nama_toko) LIKE '%$q%'
						AND
							$this->tabel_toko.status = 1
						AND 
							$this->tabel_toko.buka = 1
						AND
							$this->tabel.status = 1
						AND
							$this->tabel.verifikasi = 1
						$where
					$filter_order
					LIMIT
						$pagination[Data_ke],$limit
				");
				if ($get_produk->num_rows() == 0) {
					$hasil = array(
						'Error' => true,
						'Message' => "Produk tidak ditemukan."
					);
					goto output;
				}

				$hasil['Error'] = false;
				$hasil['Message'] = "success.";
				$no = 0;
				foreach ($get_produk->result_array() as $key) {
					if($key['diskon_dari'] != null && $key['diskon_ke'] != null) {
						if (strtotime(date('Y-m-d')) >= strtotime($key['diskon_dari']) && strtotime(date('Y-m-d')) <= strtotime($key['diskon_ke'])) {
							$diskon = $key['diskon'];
							$harga_diskon = ceil($key['harga'] - (($key['diskon']/100)*$key['harga']));
						}else {
							$diskon = 0;
							$harga_diskon = 0;
						}
					}else {
						$diskon = $key['diskon'];
						$harga_diskon = ceil($key['harga'] - (($key['diskon']/100)*$key['harga']));
					}

					$hasil['Data'][$no++] = array(
						'id' => $key['id'],
						'toko_id' => $key['toko_id'],
						'toko_logo' => $key['toko_logo'],
						'toko_banner' => $key['toko_banner'],
						'toko_slug' => $key['toko_slug'],
						'toko_nama' => $key['toko_nama'],
						'toko_deskripsi' => $key['toko_deskripsi'],
						'toko_provinsi_id' => $key['toko_provinsi_id'],
						'toko_provinsi_nama' => $key['toko_provinsi_nama'],
						'toko_kabupaten_id' => $key['toko_kabupaten_id'],
						'toko_kabupaten_nama' => $key['toko_kabupaten_nama'],
						'toko_kecamatan_id' => $key['toko_kecamatan_id'],
						'toko_kecamatan_nama' => $key['toko_kecamatan_nama'],
						'toko_catatan' => $this->_toko_catatan($key['toko_id']),
						'sku_produk' => $key['sku_produk'],
						'foto' => $this->foto_produk($key['id']),
						'nama' => $key['nama_produk'],
						'slug' => $key['slug'],
						'keterangan' => $key['keterangan'],
						'harga' => $key['harga'],
						'diskon' => $diskon,
						'harga_diskon' => $harga_diskon,
						'berat' => $key['berat'],
						'stok' => $key['stok'],
						// 'favorit' => $key['favorit'],
						'kondisi' => ($key['kondisi'] == 1) ? "Baru" : "Bekas",
						'dilihat' => $key['dilihat'],
						'minimal_beli' => $key['min_beli'],
						'kategori_id' => $key['kategori_id'],
						'kategori_nama' => $key['nama_kategori'],
						'rating' => $this->produk_rating($key['id']),
						'created_at' => $key['created_at'],
						'updated_at' => $key['updated_at']
					);
					$hasil['jumlah_data'] = $query->num_rows();
					$hasil['Pagination'] = $pagination;
				}
				goto output;
			}else if ($st == "toko") {
				$where = '';

				if (!empty($kategori_id)) {
					$cek_kategori = $this->db->query("
						SELECT
							kategori_id
						FROM
							$this->tabel_kategori
						WHERE
							id = '$kategori_id'
					")->row_array();

					if ($cek_kategori['kategori_id'] == 0) {
						$where .= " AND $this->tabel_kategori.kategori_id = '$kategori_id'";
					}else{
						$where .= " AND $this->tabel_kategori.id = '$kategori_id'";
					}
				}

				$limit = 10;

				$query = $this->db->query("
					SELECT
						$this->tabel_toko.id
					FROM
						$this->tabel_kategori
						LEFT JOIN $this->tabel ON $this->tabel.kategori_id = $this->tabel_kategori.id
						LEFT JOIN $this->tabel_toko ON $this->tabel_toko.id = $this->tabel.toko_id
					WHERE
						CONCAT($this->tabel.nama_produk, ' ', $this->tabel_toko.nama_toko) LIKE '%$q%'
						$where
					GROUP BY $this->tabel_toko.id
				");

				$config['jumlah_data'] = $query->num_rows();
				$config['limit'] = $limit;
				$config['page']	= empty($params['page'])? null : $params['page'];

				$pagination = $this->query_pagination($config);

				$get_produk = $this->db->query("
					SELECT
						$this->tabel_toko.id,
						$this->tabel_toko.logo AS toko_logo,
						$this->tabel_toko.banner AS toko_banner,
						$this->tabel_toko.slug AS toko_slug,
						$this->tabel_toko.nama_toko AS toko_nama,
						$this->tabel_toko.deskripsi AS toko_deskripsi,
						$this->tabel_toko.provinsi_id AS toko_provinsi_id,
						$this->tabel_provinsi.nama AS toko_provinsi_nama,
						$this->tabel_toko.kabupaten_id AS toko_kabupaten_id,
						CONCAT($this->tabel_kabupaten.type, ' ', $this->tabel_kabupaten.nama) AS toko_kabupaten_nama,
						$this->tabel_toko.kecamatan_id AS toko_kecamatan_id,
						$this->tabel_kecamatan.nama AS toko_kecamatan_nama
					FROM
						$this->tabel_kategori
						LEFT JOIN $this->tabel ON $this->tabel.kategori_id = $this->tabel_kategori.id
						LEFT JOIN $this->tabel_toko ON $this->tabel_toko.id = $this->tabel.toko_id
						LEFT JOIN $this->tabel_provinsi ON $this->tabel_provinsi.id = $this->tabel_toko.provinsi_id
						LEFT JOIN $this->tabel_kabupaten ON $this->tabel_kabupaten.id = $this->tabel_toko.kabupaten_id
						LEFT JOIN $this->tabel_kecamatan ON $this->tabel_kecamatan.id = $this->tabel_toko.kecamatan_id
					WHERE
						CONCAT($this->tabel.nama_produk, ' ', $this->tabel_toko.nama_toko) LIKE '%$q%'
						AND 
						$this->tabel_toko.status = 1
						AND
						$this->tabel_toko.buka = 1
						$where
					GROUP BY $this->tabel_toko.id
					LIMIT
						$pagination[Data_ke],$limit
				");
				if ($get_produk->num_rows() == 0) {
					$hasil = array(
						'Error' => true,
						'Message' => "Toko tidak ditemukan."
					);
					goto output;
				}

				$hasil['Error'] = false;
				$hasil['Message'] = "success.";
				$no = 0;
				foreach ($get_produk->result_array() as $key) {
					$hasil['Data'][$no++] = array(
						'toko_id' => $key['id'],
						'toko_logo' => $key['toko_logo'],
						'toko_banner' => $key['toko_banner'],
						'toko_slug' => $key['toko_slug'],
						'toko_nama' => $key['toko_nama'],
						'toko_deskripsi' => $key['toko_deskripsi'],
						'toko_provinsi_id' => $key['toko_provinsi_id'],
						'toko_provinsi_nama' => $key['toko_provinsi_nama'],
						'toko_kabupaten_id' => $key['toko_kabupaten_id'],
						'toko_kabupaten_nama' => $key['toko_kabupaten_nama'],
						'toko_kecamatan_id' => $key['toko_kecamatan_id'],
						'toko_kecamatan_nama' => $key['toko_kecamatan_nama']
					);
				}
				$hasil['jumlah_data'] = $query->num_rows();
				$hasil['Pagination'] = $pagination;
				goto output;
			}
		}

		output:
		return $hasil;
	}

	// private function ulasan_foto($produk_id, $ulasan_id)
	// {
	// 	$get_ulasan_foto = $this->db->query("
	// 		SELECT
	// 			CONCAT('".base_url('')."', foto) AS foto,
	// 			created_at,
	// 			updated_at
	// 		FROM
	// 			$this->tabel_ulasan_foto$produk_id
	// 		WHERE
	// 			ulasan_id = '$ulasan_id'
	// 	")->result_array();
	// 	$hasil = array();
	// 	$no = 0;
	// 	foreach ($get_ulasan_foto as $key) {
	// 		$hasil[$no++] = $key;
	// 	}

	// 	return $hasil;
	// }

	public function ulasan($params)
	{
		$produk_nama = $params['produk_nama'];
		$limit = isset($params['limit'])? $params['limit'] : 10;

		if (empty($produk_nama)) {
			$hasil = array(
				'Error' => true,
				'Message' => "Parameter 'produk_nama' tidak diset."
			);
			goto output;
		}else{
			// $get_produk_id = $this->db->query("
			// 	SELECT
			// 		id
			// 	FROM
			// 		$this->tabel
			// 	WHERE
			// 		slug = '$produk_nama'
			// ");

			// if ($get_produk_id->num_rows() == 0) {
			// 	$hasil = array(
			// 		'Error' => true,
			// 		'Message' => "Produk tidak ditemukan."
			// 	);
			// 	goto output;
			// }

			// foreach ($get_produk_id->result_array() as $key) {
			// 	$produk_id = $key['id'];
			// }

			// // $this->pembelian->create_table_ulasan($produk_id);

			// $limit = 10;

			// $query = $this->db->query("
			// 	SELECT
			// 		$this->tabel_ulasan$produk_id.id
			// 	FROM
			// 		$this->tabel_ulasan$produk_id
			// ");

			$produk = $this->db->query("SELECT
												id,
												toko_id,
												nama_produk
											FROM
												$this->tabel
											WHERE
												slug = '$produk_nama'")->row_array();
			if (!$produk) {
				$hasil['Error'] = true;
				$hasil['Message'] = "Produk tidak ditemukan";
				goto output;
			}

			$toko = $this->db->query("SELECT
	    									id,
	    									nama_toko
	    								FROM
	    									$this->tabel_toko
	    								WHERE
	    									id = '$produk[toko_id]'")->row_array();
	    	if (!$toko) {
	    		$hasil['Error'] = true;
	    		$hasil['Message'] = "Toko tidak ditemukan";
	    		goto output;
	    	}

			$jumlah_ulasan = $this->db->query("SELECT
	                                            $this->tabel_ulasan.id,
	                                            $this->tabel_ulasan.user_id,
	                                            $this->tabel_ulasan.produk_id,
	                                            $this->tabel.nama_produk,
	                                            $this->tabel_user.nama AS user_nama,
	                                            $this->tabel_ulasan.rating,
	                                            $this->tabel_ulasan.ulasan,
	                                            $this->tabel_ulasan.reply_id,
	                                            $this->tabel_ulasan.created_at,
	                                            $this->tabel_ulasan.updated_at
	                                        FROM
	                                            $this->tabel_ulasan
	                                        LEFT JOIN
	                                            $this->tabel_user
	                                            ON
	                                            $this->tabel_ulasan.user_id = $this->tabel_user.id
	                                        LEFT JOIN
	                                            $this->tabel
	                                            ON
	                                            $this->tabel_ulasan.produk_id = $this->tabel.id
	                                        WHERE
	                                            $this->tabel_ulasan.toko_id = '$toko[id]'
	                                            AND
	                                            $this->tabel_ulasan.produk_id = '$produk[id]'
	                                            AND
	                                            $this->tabel_ulasan.reply_id = '0'")->num_rows();

			if ($jumlah_ulasan == 0) {
				$hasil['Error'] = true;
				$hasil['Message'] = "Ulasan tidak ditemukan";
				goto output;
			}

			$config['jumlah_data'] = $jumlah_ulasan;
			$config['limit'] = $limit;
			$config['page']	= empty($params['page'])? null : $params['page'];

			$pagination = $this->query_pagination($config);

			$get_ulasan = $this->db->query("SELECT
	                                            $this->tabel_ulasan.id,
	                                            $this->tabel_ulasan.user_id,
	                                            $this->tabel_ulasan.produk_id,
	                                            $this->tabel.nama_produk,
	                                            $this->tabel_user.nama AS user_nama,
	                                            $this->tabel_ulasan.rating,
	                                            $this->tabel_ulasan.ulasan,
	                                            $this->tabel_ulasan.reply_id,
	                                            $this->tabel_ulasan.created_at,
	                                            $this->tabel_ulasan.updated_at
	                                        FROM
	                                            $this->tabel_ulasan
	                                        LEFT JOIN
	                                            $this->tabel_user
	                                            ON
	                                            $this->tabel_ulasan.user_id = $this->tabel_user.id
	                                        LEFT JOIN
	                                            $this->tabel
	                                            ON
	                                            $this->tabel_ulasan.produk_id = $this->tabel.id
	                                        WHERE
	                                            $this->tabel_ulasan.toko_id = '$toko[id]'
	                                            AND
	                                            $this->tabel_ulasan.produk_id = '$produk[id]'
	                                            AND
	                                            $this->tabel_ulasan.reply_id = '0'
											ORDER BY $this->tabel_ulasan.id DESC
											LIMIT
												$pagination[Data_ke],$limit
										")->result_array();
			$no = 0;
			$hasil['Error'] = false;
			$hasil['Message'] = "success.";
			$hasil['Data'] = array();
			foreach ($get_ulasan as $key) {
				$hasil['Data'][$no++] = array(
					'id' => $key['id'],
					'user_id' => $key['user_id'],
					'user_nama' => $key['user_nama'],
					'ulasan_foto' => $this->pembelian->ulasan_foto($produk['id'], $key['id']),
					'rating' => $key['rating'],
					'ulasan' => $key['ulasan'],
					'reply' => $this->get_balasan_ulasan($key['id']),
					'created_at' => $key['created_at'],
					'updated_at' => $key['updated_at']
				);
			}
			$hasil['Pagination'] = $pagination;
			goto output;
		}

		output:
		return $hasil;
	}

	private function get_balasan_ulasan($ulasan_id)
	{
		if (empty($ulasan_id)) {
			return null;
		}

		$ulasan = $this->db->query("SELECT
                                        $this->tabel_ulasan.id,
                                        $this->tabel_ulasan.user_id,
                                        $this->tabel_ulasan.produk_id,
                                        $this->tabel.nama_produk,
                                        $this->tabel_user.nama AS user_nama,
                                        $this->tabel_toko.nama_toko,
                                        $this->tabel_ulasan.rating,
                                        $this->tabel_ulasan.ulasan,
                                        $this->tabel_ulasan.reply_id,
                                        $this->tabel_ulasan.created_at,
                                        $this->tabel_ulasan.updated_at
                                    FROM
                                        $this->tabel_ulasan
                                    LEFT JOIN
                                        $this->tabel_user
                                        ON
                                        $this->tabel_ulasan.user_id = $this->tabel_user.id
                                    LEFT JOIN
                                        $this->tabel
                                        ON
                                        $this->tabel_ulasan.produk_id = $this->tabel.id
                                   LEFT JOIN
	                                   $this->tabel_toko
	                                   ON
	                                   $this->tabel_ulasan.toko_id = $this->tabel_toko.id
                                    WHERE
                                        $this->tabel_ulasan.reply_id = '$ulasan_id'
								")->result_array();
		$no = 0;
		foreach ($ulasan as $key) {
			$hasil[$no++] = array(
				'id' => $key['id'],
				'user_id' => $key['user_id'],
				'user_nama' => $key['nama_toko'],
				'ulasan_foto' => $this->pembelian->ulasan_foto($produk['id'], $key['id']),
				'rating' => $key['rating'],
				'ulasan' => $key['ulasan'],
				'created_at' => $key['created_at'],
				'updated_at' => $key['updated_at']
			);
		}
		return $hasil;
	}

	public function other_product($params)
	{
		$kategori_id = $params['kategori_id'];
		$toko_id = $params['toko_id'];
		$client_token = $params['client_token'];
		$produk_id = $params['produk_id'];

		if (empty($kategori_id)) {
			$hasil = array(
				'Error' => true,
				'Message' => "Parameter 'kategori_id' tidak diset."
			);
			goto output;
		}else if (empty($toko_id)) {
			$hasil = array(
				'Error' => true,
				'Message' => "Parameter 'toko_id' tidak diset."
			);
			goto output;
		}else{
			$query_produk_favorit = '0 AS favorit,';

			if (!empty($client_token)) {
				$user = $this->db->query("SELECT
												id as id_user
											FROM
												$this->tabel_user
											WHERE
												api_token = '$client_token'")->row_array();
				if (!$user) {
					$result['Error'] = true;
					$result['Message'] = "Pengguna tidak ditemukan";
					goto output;
				}

				$tabel_favorit = $this->tabel_produk_favorit;

				$query_produk_favorit = "(SELECT COUNT($tabel_favorit.id) FROM $tabel_favorit WHERE $tabel_favorit.produk_id = $this->tabel.id AND $tabel_favorit.user_id = '$user[id_user]') AS favorit,";
			}

			$get_produk = $this->db->query("
				SELECT
					$this->tabel.id,
					$this->tabel.toko_id,
					$this->tabel_toko.logo AS toko_logo,
					$this->tabel_toko.slug AS toko_slug,
					$this->tabel_toko.nama_toko AS toko_nama,
					$this->tabel_toko.kabupaten_id AS toko_kabupaten_id,
					CONCAT($this->tabel_kabupaten.type, ' ', $this->tabel_kabupaten.nama) AS toko_kabupaten_nama,
					$this->tabel.sku_produk,
					$this->tabel.nama_produk,
					$this->tabel.keterangan,
					$this->tabel.harga,
					$this->tabel.diskon,
					$this->tabel.diskon_dari,
					$this->tabel.diskon_ke,
					$this->tabel.slug,
					$this->tabel.berat,
					$this->tabel.stok,
					$this->tabel.kondisi,
					$this->tabel.dilihat,
					$this->tabel.min_beli,
					$this->tabel.kategori_id,
					$query_produk_favorit
					$this->tabel_kategori.nama_kategori,
					$this->tabel.created_at,
					$this->tabel.updated_at
				FROM
					$this->tabel
					LEFT JOIN $this->tabel_toko ON $this->tabel_toko.id = $this->tabel.toko_id
					LEFT JOIN $this->tabel_kabupaten ON $this->tabel_kabupaten.id = $this->tabel_toko.kabupaten_id
					LEFT JOIN $this->tabel_kategori ON $this->tabel_kategori.id = $this->tabel.kategori_id
				WHERE
					$this->tabel.toko_id = '$toko_id' AND
					$this->tabel.kategori_id = '$kategori_id' AND
					$this->tabel.id != '$produk_id'
				ORDER BY RAND()
				LIMIT 0, 10
			");
			if ($get_produk->num_rows() == 0) {
				$hasil = array(
					'Error' => true,
					'Message' => "Produk tidak ditemukan."
				);
				goto output;
			}

			$hasil['Error'] = false;
			$hasil['Message'] = "success.";
			$no = 0;
			foreach ($get_produk->result_array() as $key) {
				if($key['diskon_dari'] != null && $key['diskon_ke'] != null) {
					if (strtotime(date('Y-m-d')) >= strtotime($key['diskon_dari']) && strtotime(date('Y-m-d')) <= strtotime($key['diskon_ke'])) {
						$diskon = $key['diskon'];
						$harga_diskon = ceil($key['harga'] - (($key['diskon']/100)*$key['harga']));
					}else {
						$diskon = 0;
						$harga_diskon = 0;
					}
				}else {
					$diskon = $key['diskon'];
					$harga_diskon = ceil($key['harga'] - (($key['diskon']/100)*$key['harga']));
				}

				$hasil['Data'][$no++] = array(
					'id' => $key['id'],
					'toko_id' => $key['toko_id'],
					'toko_logo' => $key['toko_logo'],
					'toko_nama' => $key['toko_nama'],
					'toko_slug' => $key['toko_slug'],
					'toko_kabupaten_id' => $key['toko_kabupaten_id'],
					'toko_kabupaten_nama' => $key['toko_kabupaten_nama'],
					'sku_produk' => $key['sku_produk'],
					'foto' => $this->foto_produk($key['id']),
					'slug' => $key['slug'],
					'nama' => $key['nama_produk'],
					'keterangan' => $key['keterangan'],
					'harga' => $key['harga'],
					'diskon' => $diskon,
					'harga_diskon' => $harga_diskon,
					'berat' => $key['berat'],
					'stok' => $key['stok'],
					'rating' => $this->produk_rating($key['id_produk']),
					'favorit' => $key['favorit'],
					'kondisi' => ($key['kondisi'] == 1) ? "Baru" : "Bekas",
					'dilihat' => $key['dilihat'],
					'minimal_beli' => $key['min_beli'],
					'kategori_id' => $key['kategori_id'],
					'kategori_nama' => $key['nama_kategori'],
					'created_at' => $key['created_at'],
					'updated_at' => $key['updated_at']
				);
			}
			goto output;
		}

		output:
		return $hasil;
	}

	function produk_diskon($params)
	{

		$produk = $this->db->query("SELECT
										$this->tabel.id as id_produk,
										$this->tabel.toko_id,
										$this->tabel_toko.slug as slug_toko,
										$this->tabel_toko.nama_toko,
										$this->tabel_toko.provinsi_id,
										$this->tabel_provinsi.nama as nama_provinsi,
										$this->tabel_toko.kabupaten_id,
										$this->tabel_kabupaten.nama as nama_kabupaten,
										$this->tabel_toko.kecamatan_id,
										$this->tabel_kecamatan.nama as nama_kecamatan,
										$this->tabel.sku_produk,
										$this->tabel.nama_produk,
										$this->tabel.keterangan,
										$this->tabel.harga,
										$this->tabel.diskon,
										$this->tabel.diskon_dari,
										$this->tabel.diskon_ke,
										$this->tabel.berat,
										$this->tabel.stok_awal,
										$this->tabel.stok,
										$this->tabel.kondisi,
										$this->tabel.min_beli,
										$this->tabel.asuransi,
										$this->tabel.preorder,
										$this->tabel.lama_preorder,
										$this->tabel.waktu_preorder,
										$query_produk_favorit
										$this->tabel.etalase_id,
										$this->tabel.kategori_id,
										$this->tabel_kategori.nama_kategori,
										$this->tabel.slug as slug_produk,
										$this->tabel.status as status_produk
									FROM
										$this->tabel
									LEFT JOIN
										$this->tabel_kategori
									ON
										$this->tabel.kategori_id = $this->tabel_kategori.id
									LEFT JOIN
										$this->tabel_toko
									ON
										$this->tabel.toko_id = $this->tabel_toko.id
									LEFT JOIN
										$this->tabel_provinsi
									ON
										$this->tabel_toko.provinsi_id = $this->tabel_provinsi.id
									LEFT JOIN
										$this->tabel_kabupaten
									ON
										$this->tabel_toko.kabupaten_id = $this->tabel_kabupaten.id
									LEFT JOIN
										$this->tabel_kecamatan
									ON
										$this->tabel_toko.kecamatan_id = $this->tabel_kecamatan.id
									WHERE
										$this->tabel.status = 1
									AND
										$this->tabel.verifikasi = 1
									AND
										$this->tabel.diskon != '0'
									ORDER BY RAND()
									LIMIT
									0,10");
		if ($produk->num_rows() == 0) {
			$result['Error'] = true;
			$result['Message'] = "Tidak ada diskon produk";
			goto output;
		}

		$no = 0;
		$result['Error'] = false;
		$result['Message'] = null;
		foreach ($produk->result_array() as $key) {
			if($key['diskon_dari'] != null && $key['diskon_ke'] != null) {
				if (strtotime(date('Y-m-d')) >= strtotime($key['diskon_dari']) && strtotime(date('Y-m-d')) <= strtotime($key['diskon_ke'])) {
					$diskon = $key['diskon'];
					$harga_diskon = ceil($key['harga'] - (($key['diskon']/100)*$key['harga']));
				}else {
					$diskon = 0;
					$harga_diskon = 0;
				}
			}else {
				$diskon = $key['diskon'];
				$harga_diskon = ceil($key['harga'] - (($key['diskon']/100)*$key['harga']));
			}

			$result['Data'][$no++] = [
				'id_produk' => $key['id_produk'],
				'toko_id' => $key['toko_id'],
				'nama_toko' => $key['nama_toko'],
				'provinsi_id' => $key['provinsi_id'],
				'nama_provinsi' => $key['nama_provinsi'],
				'kabupaten_id' => $key['kabupaten_id'],
				'nama_kabupaten' => $key['nama_kabupaten'],
				'kecamatan_id' => $key['kecamatan_id'],
				'nama_kecamatan' => $key['nama_kecamatan'],
				'slug_toko' => $key['slug_toko'],
				'foto_produk' => $this->foto_produk($key['id_produk'])[0]['foto'],
				'sku_produk' => $key['sku_produk'],
				'nama_produk' => $key['nama_produk'],
				'keterangan' => $key['keterangan'],
				'harga' => $key['harga'],
				'diskon' => $diskon,
				'harga_diskon' => $harga_diskon,
				'berat' => $key['berat'],
				'stok_awal' => $key['stok_awal'],
				'stok' => $key['stok'],
				'kondisi' => $key['kondisi'],
				'min_beli' => $key['min_beli'],
				'asuransi' => $key['asuransi'],
				'preorder' => $key['preorder'],
				'lama_preorder' => $key['lama_preorder'],
				'waktu_preorder' => $key['waktu_preorder'],
				'etalase_id' => $key['etalase_id'],
				'kategori_id' => $key['kategori_id'],
				'nama_kategori' => $key['nama_kategori'],
				'slug_produk' => $key['slug_produk'],
				'status_produk' => $key['status_produk'],
				'favorit' => $key['favorit'],
				'rating' => $this->produk_rating($key['id_produk']),
				'wishlist' => $this->wishlist->get($user['id_user'],$key['id_produk'])
			];
		}
		goto output;
		output:
		return $result;

	}

}

/* End of file M_Product.php */
/* Location: .//F/xampp/htdocs/com/JPStore/api/base/models/M_Product.php */