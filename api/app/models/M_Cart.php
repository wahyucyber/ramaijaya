<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_Cart extends MY_Model {

	protected $tabel = "mst_keranjang";

	protected $tabel_toko = 'mst_toko';

	protected $tabel_user = 'mst_user';

	protected $tabel_produk = 'mst_produk';

	protected $tabel_produk_foto = 'mst_produk_foto';

	protected $tabel_produk_favorit = 'mst_produk_favorit';

	protected $tabel_provinsi = 'mst_provinsi';

	protected $tabel_kabupaten = 'mst_kabupaten';

	protected $tabel_kecamatan = 'mst_kecamatan';

	protected $tabel_kurir = 'mst_kurir';

	protected $tabel_biaya_admin = 'mst_biaya_admin';

	protected $tabel_ppn = 'mst_ppn';

	public function __construct()
	{
		parent::__construct();
		$this->load->model('seller/M_Kurir', 'kurir');
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

	private function get_produk($toko_id, $user_id, $tabel)
	{
		$get_produk = $this->db->query("
			SELECT
				$tabel.produk_id,
				$tabel.jumlah,
				$tabel.catatan,
				$tabel.checked,
				$this->tabel_produk.nama_produk,
				$this->tabel_produk.keterangan,
				$this->tabel_produk.harga,
				$this->tabel_produk.diskon,
				$this->tabel_produk.berat,
				$this->tabel_produk.stok,
				$this->tabel_produk.slug,
				(
					SELECT 
						COUNT(id) 
					FROM 
						$this->tabel_produk_favorit 
					WHERE 
						$this->tabel_produk_favorit.produk_id = $this->tabel.produk_id AND 
						$this->tabel_produk_favorit.user_id = '$user_id') AS favorit,
				$this->tabel_produk.min_beli
			FROM
				$tabel
				LEFT JOIN $this->tabel_produk ON $this->tabel_produk.id = $tabel.produk_id
			WHERE
				$tabel.toko_id = '$toko_id' AND
				$tabel.user_id = '$user_id'
		")->result_array();
		$hasil = array();
		$no = 0;
		foreach ($get_produk as $key) {
			$hasil[$no++] = array(
				'id' => $key['produk_id'],
				'foto' => $this->foto_produk($key['produk_id']),
				'nama' => $key['nama_produk'],
				'keterangan' => $key['keterangan'],
				'harga' => $key['harga'],
				'diskon' => $key['diskon'],
				'harga_diskon' => ceil($key['harga'] - (($key['diskon']/100)*$key['harga'])),
				'berat' => $key['berat'],
				'stok' => $key['stok'],
				'min_beli' => $key['min_beli'],
				'slug' => $key['slug'],
				'favorit' => $key['favorit'],
				'qty' => $key['jumlah'],
				'catatan' => $key['catatan'],
				'checked' => $key['checked']
			);
		}

		return $hasil;
	}

	public function add($params)
	{
		$client_token = $params['client_token'];
		$produk_id = $params['produk_id'];
		$qty = $params['qty'];
		$catatan = $params['catatan'];

		if (empty($client_token)) {
			$hasil = array(
				'Error' => true,
				'Message' => "Parameter 'client_token' tidak diset."
			);
			goto output;
		}else if (empty($produk_id)) {
			$hasil = array(
				'Error' => true,
				'Message' => "Parameter 'produk_id' tidak diset."
			);
			goto output;
		}else if (empty($qty)) {
			$hasil = array(
				'Error' => true,
				'Message' => "Parameter 'qty' tidak diset."
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

			$tabel_keranjang = $this->tabel;

			$get_produk = $this->db->query("
				SELECT
					id,
					stok,
					toko_id,
					min_beli
				FROM
					$this->tabel_produk
				WHERE
					id = '$produk_id'
			");
			if ($get_produk->num_rows() == 0) {
				$hasil = array(
					'Error' => true,
					'Message' => "Produk tidak ditemukan."
				);
				goto output;
			}

			foreach ($get_produk->result_array() as $key) {
				$produk_stok = $key['stok'];
				$produk_toko_id = $key['toko_id'];
				$produk_minimal_beli = $key['min_beli'];
			}

			if ($qty < $produk_minimal_beli) {
				$hasil = array(
					'Error' => true,
					'Message' => "QTY kurang dari minimal pembelian."
				);
				goto output;
			}

			if ($produk_stok < $qty) {
				$hasil = array(
					'Error' => true,
					'Message' => "Produk tidak dapat ditambahkan ke keranjang, stok produk: <b>".$produk_stok."</b>"
				);
				goto output;
			}

			$cek_keranjang = $this->db->query("
				SELECT
					id,
					jumlah
				FROM
					$tabel_keranjang
				WHERE
					produk_id = '$produk_id' AND
					user_id = '$user_id'
			");

			if ($cek_keranjang->num_rows() == 0) {
				goto tambah;
			}else{
				foreach ($cek_keranjang->result_array() as $key) {
					$keranjang_id = $key['id'];
					$qty_awal = $key['jumlah'];
				}

				$this->db->update($tabel_keranjang, array(
					'jumlah' => $qty_awal + $qty
				), array(
					'user_id' => $user_id,
					'id' => $keranjang_id,
					'produk_id' => $produk_id
				));

				$hasil = array(
					'Error' => false,
					'Message' => "Produk berhasil ditambahkan ke keranjang."
				);
				goto output;
			}

			tambah:
			$this->db->insert($tabel_keranjang, array(
				'user_id' => $user_id,
				'toko_id' => $produk_toko_id,
				'produk_id' => $produk_id,
				'jumlah' => $qty,
				'catatan' => $catatan
			));

			$hasil = array(
				'Error' => false,
				'Message' => "Produk berhasil ditambahkan ke keranjang."
			);
			goto output;
		}

		output:
		return $hasil;
	}

	public function list($params)
	{
		$client_token = $params['client_token'];

		if (empty($client_token)) {
			$hasil = array(
				'Error' => true,
				'Message' => "Parameter 'client_token' tidak diset."
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

			$tabel_keranjang = $this->tabel;

			$get_keranjang = $this->db->query("
				SELECT
					$tabel_keranjang.id,
					$tabel_keranjang.toko_id,
					$this->tabel_toko.logo AS toko_logo,
					$this->tabel_toko.nama_toko AS toko_nama,
					$this->tabel_toko.provinsi_id AS toko_provinsi_id,
					$this->tabel_toko.slug AS toko_slug,
					$this->tabel_provinsi.nama AS toko_provinsi_nama,
					$this->tabel_toko.kabupaten_id AS toko_kabupaten_id,
					CONCAT($this->tabel_kabupaten.type, ' ', $this->tabel_kabupaten.nama) AS toko_kabupaten_nama,
					$this->tabel_toko.kecamatan_id AS toko_kecamatan_id,
					$this->tabel_kecamatan.nama AS toko_kecamatan_nama,
					$tabel_keranjang.produk_id,
					$this->tabel_produk.nama_produk,
					$this->tabel_produk.harga,
					$this->tabel_produk.diskon,
					$this->tabel_produk.berat,
					$this->tabel_produk.stok,
					$tabel_keranjang.jumlah,
					$tabel_keranjang.catatan,
					$tabel_keranjang.checked,
					$tabel_keranjang.created_at,
					$tabel_keranjang.updated_at
				FROM
					$tabel_keranjang
					LEFT JOIn $this->tabel_toko ON $this->tabel_toko.id = $tabel_keranjang.toko_id
					LEFT JOIN $this->tabel_produk ON $this->tabel_produk.id = $tabel_keranjang.produk_id
					LEFT JOIN $this->tabel_provinsi ON $this->tabel_provinsi.id = $this->tabel_toko.provinsi_id
					LEFT JOIN $this->tabel_kabupaten ON $this->tabel_kabupaten.id = $this->tabel_toko.kabupaten_id
					LEFT JOIN $this->tabel_kecamatan ON $this->tabel_kecamatan.id = $this->tabel_toko.kecamatan_id
				WHERE
					$tabel_keranjang.user_id = '$user_id' 
					AND
					$this->tabel_toko.status = 1
					AND
					$this->tabel_produk.status = 1
					AND
					$this->tabel_produk.verifikasi = 1
			")->result_array();
			$no = 0;
			$hasil['Error'] = false;
			$hasil['Message'] = "success.";
			$hasil['Data'] = array();
			foreach ($get_keranjang as $key) {
				$hasil['Data'][$no++] = array(
					'id' => $key['id'],
					'toko_id' => $key['toko_id'],
					'toko_logo' => $key['toko_logo'],
					'toko_nama' => $key['toko_nama'],
					'toko_provinsi_id' => $key['toko_provinsi_id'],
					'toko_provinsi_nama' => $key['toko_provinsi_nama'],
					'toko_kabupaten_id' => $key['toko_kabupaten_id'],
					'toko_kabupaten_nama' => $key['toko_kabupaten_nama'],
					'toko_kecamatan_id' => $key['toko_kecamatan_id'],
					'toko_kecamatan_nama' => $key['toko_kecamatan_nama'],
					'toko_slug' => $key['toko_slug'],
					'produk_id' => $key['produk_id'],
					'produk_foto' => $this->foto_produk($key['produk_id']),
					'produk_nama' => $key['nama_produk'],
					'harga' => $key['harga'],
					'diskon' => $key['diskon'],
					'harga_diskon' => ceil($key['harga'] - (($key['diskon']/100)*$key['harga'])),
					'berat' => $key['berat'],
					'stok' => $key['stok'],
					'jumlah' => $key['jumlah'],
					'catatan' => $key['catatan'],
					'checked' => $key['checked'],
					'created_at' => $key['created_at'],
					'updated_at' => $key['updated_at']
				);
			}
			goto output;
		}

		output:
		return $hasil;
	}

	public function detail($params)
	{
		$client_token = $params['client_token'];

		if (empty($client_token)) {
			$hasil = array(
				'Error' => true,
				'Message' => "Parameter 'client_token' tidak diset."
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

			$tabel_keranjang = $this->tabel;

			$get_mitra = $this->db->query("
				SELECT
					$tabel_keranjang.toko_id,
					$this->tabel_toko.logo,
					$this->tabel_toko.nama_toko,
					$this->tabel_toko.kabupaten_id,
					$this->tabel_toko.slug AS toko_slug,
					CONCAT($this->tabel_kabupaten.type, ' ', $this->tabel_kabupaten.nama) AS kabupaten_nama,
					$this->tabel_toko.kecamatan_id AS kecamatan_id,
					$this->tabel_kecamatan.nama AS kecamatan_nama,
					(SELECT $this->tabel_user.kecamatan_id FROM $this->tabel_user WHERE $this->tabel_user.id = '$user_id') AS kecamatan_id_tujuan
				FROM
					$tabel_keranjang
					LEFT JOIN $this->tabel_toko ON $this->tabel_toko.id = $tabel_keranjang.toko_id
					LEFT JOIN $this->tabel_produk ON $this->tabel_produk.id = $tabel_keranjang.produk_id
					LEFT JOIN $this->tabel_kabupaten ON $this->tabel_kabupaten.id = $this->tabel_toko.kabupaten_id
					LEFT JOIN $this->tabel_kecamatan ON $this->tabel_kecamatan.id = $this->tabel_toko.kecamatan_id
				WHERE
					$tabel_keranjang.user_id = '$user_id' 
					AND
					$this->tabel_toko.status = 1
					AND
					$this->tabel_produk.status = 1
					AND
					$this->tabel_produk.verifikasi = 1
				GROUP BY $tabel_keranjang.toko_id
			")->result_array();
			$no = 0;
			$hasil['Error'] = false;
			$hasil['Message'] = "success.";
			$hasil['Data'] = array();
			foreach ($get_mitra as $key) {
				$hasil['Data'][$no++] = array(
					'toko_id' => $key['toko_id'],
					'toko_logo' => $key['logo'],
					'toko_nama' => $key['nama_toko'],
					'toko_kabupaten_id' => $key['kabupaten_id'],
					'toko_kabupaten_nama' => $key['kabupaten_nama'],
					'toko_kecamatan_id' => $key['kecamatan_id'],
					'toko_kecamatan_nama' => $key['kecamatan_nama'],
					'toko_slug' => $key['toko_slug'],
					'toko_produk' => $this->get_produk($key['toko_id'], $user_id, $tabel_keranjang),
					'kecamatan_id_tujuan' => $key['kecamatan_id_tujuan']
				);
			}
		}

		output:
		return $hasil;
	}

	public function delete($params)
	{
		$delete = json_decode($params['delete'], true);

		$produk_total = count($delete['produk']);

		if ($produk_total == 0) {
			$hasil = array(
				'Error' => true,
				'Message' => "Produk belum dipilih."
			);
			goto output;
		}

		$client_token = $delete['client_token'];

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

		$produk = $delete['produk'];

		foreach ($produk as $key) {
			$this->db->delete($this->tabel, array(
				'user_id' => $user_id,
				'produk_id' => $key['id']
			));
		}

		$hasil = array(
			'Error' => false,
			'Message' => "Produk berhasil dihapus."
		);
		goto output;

		output:
		return $hasil;
	}

    public function set_catatan($params)
	{
		$client_token = isset($params['client_token'])? $params['client_token'] : '';
		$produk_id = isset($params['produk_id'])? $params['produk_id'] : '';
		$catatan = isset($params['catatan'])? $params['catatan'] : '';
		if (empty($client_token)) {
			$hasil = array(
				'Error' => true,
				'Message' => "Parameter 'client_token' tidak diset."
			);
			goto output;
		}else if (empty($produk_id)) {
			$hasil = array(
				'Error' => true,
				'Message' => "Parameter 'produk_id' tidak diset."
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

		$tabel_keranjang = $this->tabel;

		$cek_produk = $this->db->query("
			SELECT
				$tabel_keranjang.id,
				$this->tabel_produk.stok,
				$this->tabel_produk.min_beli
			FROM
				$tabel_keranjang
				LEFT JOIN $this->tabel_produk ON $this->tabel_produk.id = $tabel_keranjang.produk_id
			WHERE
				$tabel_keranjang.produk_id = '$produk_id' AND
				$tabel_keranjang.user_id = '$user_id'
		");
		if ($cek_produk->num_rows() == 0) {
			$hasil = array(
				'Error' => true,
				'Message' => "Produk tidak ditemukan."
			);
			goto output;
		}

		$this->db->update($tabel_keranjang, array(
			'catatan' => $catatan
		), array(
			'user_id' => $user_id,
			'produk_id' => $produk_id
		));
		$hasil = array(
			'Error' => false,
			'Message' => "Berhasil mengubah catatan."
		);
		goto output;
		output:
		return $hasil;

	}

	public function set_qty($params)
	{
		$client_token = $params['client_token'];
		$produk_id = $params['produk_id'];
		$qty = $params['qty'];

		if (empty($client_token)) {
			$hasil = array(
				'Error' => true,
				'Message' => "Parameter 'client_token' tidak diset."
			);
			goto output;
		}else if (empty($produk_id)) {
			$hasil = array(
				'Error' => true,
				'Message' => "Parameter 'produk_id' tidak diset."
			);
			goto output;
		}else if (empty($qty)) {
			$hasil = array(
				'Error' => true,
				'Message' => "Parameter 'qty' tidak diset."
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

		$tabel_keranjang = $this->tabel;

		$cek_produk = $this->db->query("
			SELECT
				$tabel_keranjang.id,
				$this->tabel_produk.stok,
				$this->tabel_produk.min_beli
			FROM
				$tabel_keranjang
				LEFT JOIN $this->tabel_produk ON $this->tabel_produk.id = $tabel_keranjang.produk_id
			WHERE
				$tabel_keranjang.produk_id = '$produk_id' AND
				$tabel_keranjang.user_id = '$user_id'
		");
		if ($cek_produk->num_rows() == 0) {
			$hasil = array(
				'Error' => true,
				'Message' => "Produk tidak ditemukan."
			);
			goto output;
		}

		foreach ($cek_produk->result_array() as $key) {
			$stok = $key['stok'];
			$minimal_beli = $key['min_beli'];
		}

		if ($stok < $qty) {
			$hasil = array(
				'Error' => true,
				'Message' => "QTY melebihi stok produk, yaitu: <b>$stok</b>"
			);
			goto output;
		}

		if ($qty < $minimal_beli) {
			$hasil = array(
				'Error' => true,
				'Message' => "QTY kurang dari minimal pembelian, yaitu : <b>$minimal_beli</b>"
			);
			goto output;
		}

		$this->db->update($tabel_keranjang, array(
			'jumlah' => $qty
		), array(
			'user_id' => $user_id,
			'produk_id' => $produk_id
		));

		$hasil = array(
			'Error' => false,
			'Message' => "Produk berhasil diperbarui."
		);
		goto output;

		output:
		return $hasil;
	}

	public function set_checked($params)
	{
		$client_token = $params['client_token'];
		$produk = json_decode($params['produk'], true);

		if (empty($client_token)) {
			$hasil = array(
				'Error' => true,
				'Message' => "Parameter 'client_token' tidak diset."
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

			$this->db->update($this->tabel, array(
				'checked' => "0"
			), array(
				'user_id' => $user_id
			));

			foreach ($produk as $key) {
				$this->db->update($this->tabel, array(
					'checked' => "1"
				), array(
					'user_id' => $user_id,
					'produk_id' => $key['id']
				));
			}

			$hasil = array(
				'Error' => false,
				'Message' => "Produk berhasil dicentang."
			);
			goto output;
		}

		output:
		return $hasil;
	}

	public function checkout_produk($toko_id, $user_id)
	{
		$get_produk = $this->db->query("
			SELECT
				$this->tabel.produk_id,
				$this->tabel_produk.nama_produk,
				$this->tabel_produk.harga,
				$this->tabel_produk.diskon,
				$this->tabel_produk.berat,
				$this->tabel.catatan,
				$this->tabel.jumlah
			FROM
				$this->tabel
				LEFT JOIN $this->tabel_produk ON $this->tabel_produk.id = $this->tabel.produk_id
			WHERE
				$this->tabel.toko_id = '$toko_id' AND
				$this->tabel.checked = '1' AND
				$this->tabel.user_id = '$user_id'
		")->result_array();
		$no = 0;
		$hasil = array();
		foreach ($get_produk as $key) {
			$hasil[$no++] = array(
				'produk_id' => $key['produk_id'],
				'foto' => $this->foto_produk($key['produk_id']),
				'nama_produk' => $key['nama_produk'],
				'harga' => $key['harga'],
				'diskon' => $key['diskon'],
				'harga_diskon' => ceil($key['harga'] - (($key['diskon']/100)*$key['harga'])),
				'berat' => $key['berat'],
				'catatan' => $key['catatan'],
				'jumlah' => $key['jumlah']
			);
		}

		return $hasil;
	}

	public function checkout($params)
	{
		$client_token = $params['client_token'];

		if (empty($client_token)) {
			$hasil = array(
				'Error' => true,
				'Message' => "Parameter 'client_token' tidak diset."
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

			$cek_produk_checked = $this->db->query("
				SELECT
					id
				FROM
					$this->tabel
				WHERE
					checked = '1' AND
					user_id = '$user_id'
			")->num_rows();

			if ($cek_produk_checked == 0) {
				$hasil = array(
					'Error' => true,
					'Message' => "Produk belum dipilih."
				);
				goto output;
			}

			$get_user = $this->db->query("
				SELECT
					kecamatan_id
				FROM
					$this->tabel_user
				WHERE
					id = '$user_id'
			")->row_array();
			$kecamatan_id_tujuan = $get_user['kecamatan_id'];

			$get_lapak = $this->db->query("
				SELECT
					$this->tabel.toko_id,
					$this->tabel_toko.logo,
					$this->tabel_toko.nama_toko,
					$this->tabel_toko.kecamatan_id,
					CONCAT($this->tabel_kabupaten.type, ' ', $this->tabel_kabupaten.nama) AS kabupaten_nama
				FROM
					$this->tabel
					LEFT JOIN $this->tabel_toko ON $this->tabel_toko.id = $this->tabel.toko_id
					LEFT JOIN $this->tabel_kabupaten ON $this->tabel_kabupaten.id = $this->tabel_toko.kabupaten_id
				WHERE
					$this->tabel.checked = '1' AND
					$this->tabel.user_id = '$user_id'
				GROUP BY $this->tabel.toko_id
			")->result_array();
			$no = 0;

			$data_ppn = $this->db->query("SELECT
												ppn
											FROM
												$this->tabel_ppn
											ORDER BY id DESC
											LIMIT 0,1")->row_array();
			$data_biaya_admin = $this->db->query("SELECT
														biaya
													FROM
														$this->tabel_biaya_admin
													ORDER BY id DESC 
													LIMIT 0,1")->row_array();

			$hasil['Error'] = false;
			$hasil['Message'] = "Success.";
			$hasil['Biaya'] = [
				[
					'name' => 'ppn',
					'value' => $data_ppn['ppn']
				],
				[
					'name' => 'admin',
					'value' => $data_biaya_admin['biaya']
				]
			];
			$hasil['Data'] = array();
			foreach ($get_lapak as $key) {
				$hasil['Data'][$no++] = array(
					'toko_id' => $key['toko_id'],
					'toko_logo' => $key['toko_logo'],
					'toko_nama' => $key['nama_toko'],
					'toko_kabupaten' => $key['kabupaten_nama'],
					'asal_kecamatan_id' => $key['kecamatan_id'],
					'tujuan_kecamatan_id' => $kecamatan_id_tujuan,
					'produk' => $this->checkout_produk($key['toko_id'], $user_id)
				);
			}
			goto output;
		}

		output:
		return $hasil;
	}

	public function checkout_kurir($params)
	{
		$client_token = $params['client_token'];
		$toko_id = $params['toko_id'];

		if (empty($client_token)) {
			$hasil = array(
				'Error' => true,
				'Message' => "Parameter 'client_token' tidak diset."
			);
			goto output;
		}else if (empty($toko_id)) {
			$hasil = array(
				'Error' => true,
				'Message' => "Parameter 'toko_id' tidak diset."
			);
			goto output;
		}else{
			$get_kurir = $this->db->query("
				SELECT
					code
				FROM
					$this->tabel_kurir
				WHERE
					toko_id = '$toko_id'
			")->result_array();
			$no = 0;
			$hasil['Error'] = false;
			$hasil['Message'] = "success.";
			$hasil['Data'] = array();
			foreach ($get_kurir as $key) {
				$hasil['Data'][$no++] = $key;
			}
			goto output;
		}

		output:
		return $hasil;
	}

}

/* End of file M_Cart.php */
/* Location: ./application/models/M_Cart.php */