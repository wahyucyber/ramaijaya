<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_Pembelian extends MY_Model {

	protected $tabel = 'mst_transaksi';

	protected $tabel_transaksi_ajukan_pencairan = 'mst_transaksi_pengajuan_pencairan';

	protected $tabel_transaksi_refund = 'mst_transaksi_refund';

	protected $tabel_transaksi_detail = 'mst_transaksi_detail';

	protected $tabel_transaksi_produk = 'mst_transaksi_produk';

	protected $tabel_transaksi_log = 'mst_transaksi_log';

	protected $tabel_transaksi_pengaturan = 'mst_transaksi_pengaturan';

	protected $tabel_alamat = 'mst_alamat_pengiriman';

	protected $tabel_provinsi = 'mst_provinsi';

	protected $tabel_kabupaten = 'mst_kabupaten';

	protected $tabel_kecamatan = 'mst_kecamatan';

	protected $tabel_toko = 'mst_toko';

	protected $tabel_produk = 'mst_produk';

	protected $tabel_produk_foto = 'mst_produk_foto';

	protected $tabel_biaya_admin = 'mst_biaya_admin';

	protected $tabel_pembayaran_manual = 'mst_pembayaran_manual';

	protected $tabel_produk_ulasan = 'mst_produk_ulasan';

	protected $tabel_produk_ulasan_foto = 'mst_produk_ulasan_foto';

	protected $tabel_keranjang = 'mst_keranjang';

	protected $tabel_user = 'mst_user';
	
	protected $tabel_notifikasi = 'notifikasi';
	
	protected $tabel_komplain = 'mst_produk_komplain';

	protected $tabel_ulasan = 'mst_produk_ulasan';

	protected $tabel_ulasan_foto = 'mst_produk_ulasan_foto';

	public function __construct()
	{
		parent::__construct();
		$this->load->library('Upload_image','upload_image');
		$this->load->model('user/M_Alamat_pengiriman', 'alamat_pengiriman');
		$this->load->model('M_Ongkir', 'ongkir');
	}

	private function total_bayar_kurir($transaksi_id)
	{
		$get_kurir = $this->db->query("
			SELECT
				kurir_value
			FROM
				$this->tabel_transaksi_detail
			WHERE
				transaksi_id = '$transaksi_id'
		")->result_array();
		$total_kurir = 0;
		foreach ($get_kurir as $key) {
			$total_kurir += $key['kurir_value'];
		}

		return $total_kurir;
	}

	private function total_bayar($transaksi_id)
	{
		$get_barang = $this->db->query("
			SELECT
				SUM(qty * harga) AS total
			FROM
				$this->tabel_transaksi_produk
			WHERE
				transaksi_id = '$transaksi_id'
		")->result_array();
		$total = 0;
		foreach ($get_barang as $key) {
			$total += $key['total'];
		}

		return $total + $this->total_bayar_kurir($transaksi_id);
	}

	private function get_maksimal_pengiriman()
	{
		$get_pengaturan = $this->db->query("
			SELECT
				maksimal_diproses
			FROM
				$this->tabel_transaksi_pengaturan
		")->row_array();
		return $get_pengaturan['maksimal_diproses'];
	}

	private function get_toko($transaksi_id, $transaksi_status, $user_id)
	{
		$transaksi_id = $transaksi_id;

		awal:

		$get_toko = $this->db->query("
			SELECT
				$this->tabel_transaksi_detail.toko_id,
				$this->tabel_transaksi_detail.no_transaksi,
				$this->tabel_transaksi_detail.status,
				$this->tabel_toko.logo AS toko_logo,
				$this->tabel_toko.nama_toko AS toko_nama,
				$this->tabel_toko.kabupaten_id AS toko_kabupaten_id,
				CONCAT($this->tabel_kabupaten.type, ' ', $this->tabel_kabupaten.nama) AS toko_kabupaten_nama,
				$this->tabel_transaksi_detail.kurir,
				$this->tabel_transaksi_detail.kurir_code,
				$this->tabel_transaksi_detail.kurir_service,
				$this->tabel_transaksi_detail.kurir_resi,
				$this->tabel_transaksi_detail.kurir_etd,
				$this->tabel_transaksi_detail.kurir_value,
				$this->tabel_transaksi_detail.expired_at,
				$this->tabel_transaksi_detail.log_diproses,
				$this->tabel_transaksi_detail.log_dikirim,
				$this->tabel_transaksi_detail.log_diterima
			FROM
				$this->tabel_transaksi_detail
				LEFT JOIN $this->tabel_toko ON $this->tabel_toko.id = $this->tabel_transaksi_detail.toko_id
				LEFT JOIN $this->tabel_kabupaten ON $this->tabel_kabupaten.id = $this->tabel_toko.kabupaten_id
			WHERE
			$this->tabel_transaksi_detail.transaksi_id = '$transaksi_id' AND
			$this->tabel_transaksi_detail.user_id = '$user_id'
		")->result_array();
		$no = 0;
		foreach ($get_toko as $key) {
			$status = "Menunggu pembayaran";

			if ($transaksi_status == 1 || $transaksi_status == 2) {
				if ($key['status'] == 1) {
					$status = "Menunggu diproses";
				}else if ($key['status'] == 2) {
					$status = "Diproses";
				}else if ($key['status'] == 3) {
					$status = "Dikirim";
				}else if ($key['status'] == 4) {
					$status = "Selesai";
				}else if ($key['status'] == 0) {
					$status = "Dibatalkan";
				}

				if ($key['status'] == 1 || $key['status'] == 2) {
					$waktu_awal = strtotime($key['expired_at']);
					$waktu_sekarang = strtotime(date('Y-m-d H:i:s'));

					if ($waktu_awal < $waktu_sekarang) {
						$this->db->update($this->tabel_transaksi_detail, array(
							'status' => '0',
							'log_dibatalkan' => date("Y-m-d H:i:s")
						), array(
							'no_transaksi' => $key['no_transaksi'],
							'toko_id' => $key['toko_id'],
							'transaksi_id' => $transaksi_id
						));

						$this->db->insert($this->tabel_transaksi_refund, array(
							'transaksi_id' => $transaksi_id,
							'no_transaksi' => $key['no_transaksi'],
							'user_id' => $user_id
						));

						goto awal;
					}
				}
			}

			$hasil[$no++] = array(
				'no_transaksi' => $key['no_transaksi'],
				'status' => $status,
				'toko_id' => $key['toko_id'],
				'toko_logo' => $key['toko_logo'],
				'toko_nama' => $key['toko_nama'],
				'toko_kabupaten_id' => $key['toko_kabupaten_id'],
				'toko_kabupaten_nama' => $key['toko_kabupaten_nama'],
				'kurir' => $key['kurir'],
				'kurir_code' => $key['kurir_code'],
				'kurir_service' => $key['kurir_service'],
				'kurir_resi' => $key['kurir_resi'],
				'kurir_etd' => $key['kurir_etd'],
				'kurir_value' => $key['kurir_value'],
				'expired_at' => $key['expired_at'],
				'log_diproses' => $key['log_diproses'],
				'log_dikirim' => $key['log_dikirim'],
				'log_diterima' => $key['log_diterima'],
				'produk' => $this->get_produk($transaksi_id, $key['toko_id'])
			);
		}

		return $hasil;
	}

	private function get_produk($transaksi_id, $toko_id)
	{
		$get_produk = $this->db->query("
			SELECT
				$this->tabel_transaksi_produk.produk_id,
				$this->tabel_produk.nama_produk AS produk_nama,
				$this->tabel_produk.berat AS produk_berat,
				$this->tabel_transaksi_produk.harga,
				$this->tabel_transaksi_produk.qty,
				$this->tabel_transaksi_produk.catatan
			FROM
				$this->tabel_transaksi_produk
				LEFT JOIN $this->tabel_produk ON $this->tabel_produk.id = $this->tabel_transaksi_produk.produk_id
			WHERE 
				$this->tabel_transaksi_produk.toko_id = '$toko_id' AND
				$this->tabel_produk.status = 1 AND
				$this->tabel_produk.verifikasi = 1 AND
				$this->tabel_transaksi_produk.transaksi_id = '$transaksi_id'
		")->result_array();
		$no = 0;
		foreach ($get_produk as $key) {
			$hasil[$no++] = array(
				'produk_id' => $key['produk_id'],
				'produk_foto' => $this->get_produk_foto($key['produk_id']),
				'produk_nama' => $key['produk_nama'],
				'produk_harga' => $key['harga'],
				'produk_berat' => $key['produk_berat'],
				'qty' => $key['qty'],
				'catatan' => $key['catatan'],
				'komplain' => $this->get_komplain($key['produk_id'],$transaksi_id)
			);
		}

		return $hasil;
	}
	
	
	private function get_komplain($produk_id,$transaksi_id)
	{
	    
	   $transaksi = $this->db->query("SELECT
	                                   id,
	                                   user_id,
	                                   no_invoice
	                                FROM
	                                    $this->tabel
	                               WHERE
	                                    id = '$transaksi_id'")->row_array();
	    
	    $komplain = $this->db->query("SELECT
                                                id
                                            FROM
                                                $this->tabel_komplain
                                            WHERE
                                                user_id = '$transaksi[user_id]'
                                                AND
                                                no_invoice = '$transaksi[no_invoice]'
                                                AND
                                                produk_id = '$produk_id'")->num_rows();
        return $komplain;
	}

	private function get_produk_foto($produk_id)
	{
		$get_foto = $this->db->query("
			SELECT
				$this->tabel_produk_foto.id,
				CONCAT('".base_url('')."', $this->tabel_produk_foto.foto) AS foto
			FROM
				$this->tabel_produk_foto
			WHERE
				$this->tabel_produk_foto.produk_id = '$produk_id'
		")->result_array();
		$no = 0;
		foreach ($get_foto as $key) {
			$hasil[$no++] = $key;
		}

		return $hasil;
	}

	public function ulasan_foto($produk_id, $ulasan_id)
	{
		$get_foto = $this->db->query("
			SELECT
				id,
				CONCAT('".base_url('')."', foto) AS foto
			FROM
				$this->tabel_ulasan_foto
			WHERE
				ulasan_id = '$ulasan_id'
				AND
				produk_id = '$produk_id'
		");
		$result = null;
		$no = 0;
		if ($get_foto->num_rows() > 0) {
			foreach ($get_foto->result_array() as $key) {
				$result[$no++] = $key;
			}
		}
		return $result;
	}

	public function tagihan($params)
	{
		$client_token = $params['client_token'];
		$start = $params['start'];
		$length = $params['length'];
		$draw = $params['draw'];
		$search = $params['search']['value'];

		if (empty($client_token)) {
			$hasil = array(
				'Error' => true,
				'Message' => "Parameter 'client_token' tidak diset."
			);
			goto output;
		}else{
			awal:

			$user_id = $this->get_user_id($client_token);

			if ($user_id == null) {
				$hasil = array(
					'Error' => true,
					'Message' => "User tidak ditemukan."
				);
				goto output;
			}

			$get_biaya_admin = $this->db->query("
				SELECT
					biaya
				FROM
					$this->tabel_biaya_admin
				WHERE
					id = '1'
			")->row_array();

			$biaya_admin = $get_biaya_admin['biaya'];

			$where = (!empty($search)) ? " AND $this->tabel.no_invoice LIKE '%$search%'":"";

			$jumlah_data = $this->db->query("
				SELECT
					$this->tabel.id,
					$this->tabel.no_invoice,
					$this->tabel.alamat_id,
					$this->tabel_alamat.nama AS alamat_nama,
					$this->tabel_alamat.penerima_nama AS alamat_penerima_nama,
					$this->tabel_alamat.penerima_no_telepon AS alamat_penerima_telepon,
					$this->tabel_alamat.provinsi_id AS alamat_provinsi_id,
					$this->tabel_provinsi.nama AS alamat_provinsi_nama,
					$this->tabel_alamat.kabupaten_id AS alamat_kabupaten_id,
					CONCAT($this->tabel_kabupaten.type, ' ', $this->tabel_kabupaten.nama) AS alamat_kabupaten_nama,
					$this->tabel_alamat.kecamatan_id AS alamat_kecamatan_id,
					$this->tabel_kecamatan.nama AS alamat_kecamatan_nama,
					$this->tabel_alamat.alamat AS alamat_alamat,
					$this->tabel.status,
					$this->tabel.payment_metode,
					$this->tabel.payment_nama,
					$this->tabel.payment_output,
					$this->tabel.ppn,
					$this->tabel.created_at,
					$this->tabel.updated_at
				FROM
					$this->tabel
					LEFT JOIN $this->tabel_alamat ON $this->tabel_alamat.id = $this->tabel.alamat_id
					LEFT JOIN $this->tabel_provinsi ON $this->tabel_provinsi.id = $this->tabel_alamat.provinsi_id
					LEFT JOIN $this->tabel_kabupaten ON $this->tabel_kabupaten.id = $this->tabel_alamat.kabupaten_id
					LEFT JOIN $this->tabel_kecamatan ON $this->tabel_kecamatan.id = $this->tabel_alamat.kecamatan_id
				WHERE
					$this->tabel.is_selesai = '1' AND
					$this->tabel.user_id = '$user_id' AND
					$this->tabel.is_hapus = '0' AND
					$this->tabel.status = '0'
					$where
				ORDER BY id DESC
			
			")->num_rows();

			$get_pembelian = $this->db->query("
				SELECT
					$this->tabel.id,
					$this->tabel.no_invoice,
					$this->tabel.alamat_id,
					$this->tabel_alamat.nama AS alamat_nama,
					$this->tabel_alamat.penerima_nama AS alamat_penerima_nama,
					$this->tabel_alamat.penerima_no_telepon AS alamat_penerima_telepon,
					$this->tabel_alamat.provinsi_id AS alamat_provinsi_id,
					$this->tabel_provinsi.nama AS alamat_provinsi_nama,
					$this->tabel_alamat.kabupaten_id AS alamat_kabupaten_id,
					CONCAT($this->tabel_kabupaten.type, ' ', $this->tabel_kabupaten.nama) AS alamat_kabupaten_nama,
					$this->tabel_alamat.kecamatan_id AS alamat_kecamatan_id,
					$this->tabel_kecamatan.nama AS alamat_kecamatan_nama,
					$this->tabel_alamat.alamat AS alamat_alamat,
					$this->tabel.status,
					$this->tabel.payment_metode,
					$this->tabel.payment_nama,
					$this->tabel.payment_output,
					$this->tabel.ppn,
					$this->tabel.created_at,
					$this->tabel.updated_at
				FROM
					$this->tabel
					LEFT JOIN $this->tabel_alamat ON $this->tabel_alamat.id = $this->tabel.alamat_id
					LEFT JOIN $this->tabel_provinsi ON $this->tabel_provinsi.id = $this->tabel_alamat.provinsi_id
					LEFT JOIN $this->tabel_kabupaten ON $this->tabel_kabupaten.id = $this->tabel_alamat.kabupaten_id
					LEFT JOIN $this->tabel_kecamatan ON $this->tabel_kecamatan.id = $this->tabel_alamat.kecamatan_id
				WHERE
					$this->tabel.is_selesai = '1' AND
					$this->tabel.user_id = '$user_id' AND
					$this->tabel.is_hapus = 0 AND
					$this->tabel.status = '0'
					$where
				ORDER BY id DESC
				LIMIT $start,$length
			")->result_array();
			$no = 0;

			$hasil['Error'] = false;
			$hasil['Message'] = "success.";
			$hasil['Data'] = array();
			$expire = [];
			$log_dibatalkan = [];
			$sattlement = [];
			$log = [];
			foreach ($get_pembelian as $key) {
				$status = "Belum dibayar";
				if ($key['status'] == 0 && $key['payment_metode'] == "midtrans") {
					$status = "Belum dibayar";
					$midtrans = $this->midtrans(array(
						"url" => $key['no_invoice']."/status"
					));
	
					if ($midtrans['transaction_status'] == "expire") {
						$expire[$no] = array(
							'status' => '2',
							'no_invoice' => $key['no_invoice']
						);

						$log_dibatalkan[$no] = array(
							'status' => '0',
							'log_dibatalkan' => date("Y-m-d H:i:s"),
							'transaksi_id' => $key['id']
						);
					}else if ($midtrans['transaction_status'] == "settlement") {
						$sattlement[$no] = array(
							'status' => '1',
							'no_invoice' => $key['no_invoice']
						);
	
						$log[$no] = array(
							'expired_at' => date('Y-m-d H:i:s', strtotime("+".$this->get_maksimal_pengiriman()." days", strtotime(date('Y-m-d H:i:s')))),
							'transaksi_id' => $key['id']
						);
					}
				}else if ($key['status'] == 1) {
					$status = "Dibayar";
				}else if ($key['status'] == 2) {
					$status = "Dibatalkan";
				}

				$hasil['Data'][$no++] = array(
					'id' => $key['id'],
					'no_invoice' => $key['no_invoice'],
					'alamat_id' => $key['alamat_id'],
					'alamat_nama' => $key['alamat_nama'],
					'alamat_penerima_nama' => $key['alamat_penerima_nama'],
					'alamat_penerima_telepon' => $key['alamat_penerima_telepon'],
					'alamat_provinsi_id' => $key['alamat_provinsi_id'],
					'alamat_provinsi_nama' => $key['alamat_provinsi_nama'],
					'alamat_kabupaten_id' => $key['alamat_kabupaten_id'],
					'alamat_kabupaten_nama' => $key['alamat_kabupaten_nama'],
					'alamat_kecamatan_id' => $key['alamat_kecamatan_id'],
					'alamat_kecamatan_nama' => $key['alamat_kecamatan_nama'],
					'alamat_detail' => $key['alamat_alamat'],
					'status' => $status,
					'total_bayar' => $this->total_bayar($key['id']) + $biaya_admin + $key['ppn'],
					'payment_metode' => $key['payment_metode'],
					'payment_nama' => $key['payment_nama'],
					'payment_output' => $key['payment_output'],
					'created_at' => $key['created_at'],
					'updated_at' => $key['updated_at']
				);
			}
			$this->db->update_batch($this->tabel, $expire, 'no_invoice');
			$this->db->update_batch($this->tabel_transaksi_detail, $log_dibatalkan, 'transaksi_id');
			$this->db->update_batch($this->tabel, $sattlement, 'no_invoice');
			$this->db->update_batch($this->tabel_transaksi_log, $log, 'transaksi_id');

			// $hasil['recordsTotal'] = $this->recordsTotal($this->tabel." WHERE $this->tabel.is_selesai = '1' AND $this->tabel.user_id = '$user_id'");
			$hasil['recordsTotal'] = $jumlah_data;
			// $hasil['recordsFiltered'] = $this->recordsFiltered($this->tabel, "$this->tabel.id", "$this->tabel.is_selesai = '1' AND $this->tabel.user_id = '$user_id' $where");
			$hasil['recordsFiltered'] = count($get_pembelian);
			$hasil['draw'] = $draw;
			$hasil['user_id'] = $user_id;
			goto output;

			
		}

		output:
		return $hasil;
	}

	// public function index($params)
	// {
	// 	$client_token = isset($params['client_token'])? $params['client_token'] : '';
	// 	$status = isset($params['status'])? $params['status'] : 'all';
	// 	if (empty($client_token)) {
	// 		$result['Error'] = true;
	// 		$result['Message'] = "Paremeter client_token tidak diset";
	// 		goto output;
	// 	}

	// 	if ($status !== 'all') {
	// 		$where = "AND $this->tabel_transaksi_detail.status = '$status'";
	// 	}
		
	// 	$user = $this->db->query("SELECT
	// 									id
	// 								FROM
	// 									$this->tabel_user
	// 								WHERE
	// 									api_token = '$client_token'")->row_array();
	// 	if (!$user) {
	// 		$result['Error'] = true;
	// 		$result['Message'] = "Pengguna tidak ditemukan";
	// 		goto output;
	// 	}

	// 	$detail_transaksi = $this->db->query("SELECT
	// 												$this->tabel_transaksi_detail.id,
	// 												$this->tabel_transaksi_detail.transaksi_id,
	// 												$this->tabel_transaksi_detail.user_id,
	// 												$this->tabel_user.nama as nama_user,
	// 												$this->tabel_alamat.alamat as alamat_detail,
	// 												$this->tabel_kecamatan.nama as alamat_kecamatan_nama,
	// 												$this->tabel_kabupaten.nama as alamat_kabupaten_nama,
	// 												$this->tabel_provinsi.nama as alamat_provinsi_nama,
	// 												$this->tabel_transaksi_detail.no_transaksi,
	// 												$this->tabel.no_invoice,
	// 												$this->tabel.total_bayar,
	// 												$this->tabel.ppn,
	// 												$this->tabel_transaksi_detail.kurir,
	// 												$this->tabel_transaksi_detail.kurir_code,
	// 												$this->tabel_transaksi_detail.kurir_service,
	// 												$this->tabel_transaksi_detail.kurir_resi,
	// 												$this->tabel_transaksi_detail.kurir_etd,
	// 												$this->tabel_transaksi_detail.kurir_value,
	// 												$this->tabel_transaksi_detail.status,
	// 												$this->tabel_transaksi_detail.log_diproses,
	// 												$this->tabel_transaksi_detail.log_dikirim,
	// 												$this->tabel_transaksi_detail.log_diterima,
	// 												$this->tabel_transaksi_detail.expired_at
	// 											FROM
	// 												$this->tabel_transaksi_detail
	// 											LEFT JOIN
	// 												$this->tabel
	// 												ON
	// 												$this->tabel_transaksi_detail.transaksi_id=$this->tabel.id
	// 											LEFT JOIN
	// 												$this->tabel_user
	// 												ON
	// 												$this->tabel_transaksi_detail.user_id=$this->tabel_user.id
	// 											LEFT JOIN
	// 												$this->tabel_alamat
	// 												ON
	// 												$this->tabel.alamat_id=$this->tabel_alamat.id
	// 											LEFT JOIN
	// 												$this->tabel_kecamatan
	// 												ON
	// 												$this->tabel_alamat.kecamatan_id=$this->tabel_kecamatan.id
	// 											LEFT JOIN
	// 												$this->tabel_kabupaten
	// 												ON
	// 												$this->tabel_alamat.kabupaten_id=$this->tabel_kabupaten.id
	// 											LEFT JOIN
	// 												$this->tabel_provinsi
	// 												ON
	// 												$this->tabel_alamat.provinsi_id=$this->tabel_provinsi.id
	// 												")

	// 	$this->db->update_batch($this->tabel, $expire, 'no_invoice');
	// 	$this->db->update_batch($this->tabel, $sattlement, 'no_invoice');
	// 	$this->db->update_batch($this->tabel_transaksi_log, $log, 'transaksi_id');
	// 	output:
	// 	return $hasil;
	// }

	public function index($params)
	{
		$params = __hsp($params);
		$client_token = isset($params['client_token'])? $params['client_token'] : '';
		$page = isset($params['page'])? $params['page'] : 1;
		$limit = isset($params['limit'])? $params['limit'] : 10;
		$keyword = isset($params['keyword'])? $params['keyword'] : '';
		$status = isset($params['status'])? $params['status'] : 'all';
		if (empty($client_token)) {
			$result['Error'] = true;
			$result['Message'] = "Paremeter client_token tidak diset";
			goto output;
		}

		$user = $this->db->query("SELECT
										id
									FROM
										$this->tabel_user
									WHERE
										api_token = '$client_token'")->row_array();
		if (!$user) {
			$result['Error'] = true;
			$result['Message'] = "Pengguna tidak ditemukan";
			goto output;
		}

		$where = '';

		$where_status = "";

		switch ($status) {
			case 'all':
				break;
			case 'belum-dibayar':
				$where_status .= "AND $this->tabel.status = '0'";
				break;
			case 'dibatalkan':
				$where_status .= "AND $this->tabel.status = '2'";
				break;
			case '1':
				$where_status .= "AND $this->tabel.status = '1' AND $this->tabel_transaksi_detail.status = '$status'";
				break;
			case '2':
				$where_status .= "AND $this->tabel.status = '1' AND $this->tabel_transaksi_detail.status = '$status'";
				break;
			case '3':
				$where_status .= "AND $this->tabel.status = '1' AND $this->tabel_transaksi_detail.status = '$status'";
				break;
			case '4':
				$where_status .= "AND $this->tabel_transaksi_detail.status = '$status'";
				break;
			// case '5':
			// 	$where_status .= "AND $this->tabel_transaksi_detail.status = '$status'";
			// 	break;
			
			default:
				break;
		}

		$user_id = $user['id'];

		$jumlah_data = $this->db->query("
			SELECT
				$this->tabel_transaksi_detail.id,
				$this->tabel_transaksi_detail.transaksi_id,
				$this->tabel_transaksi_detail.toko_id,
				$this->tabel_toko.nama_toko AS toko_nama,
				$this->tabel_transaksi_detail.no_transaksi,
				$this->tabel.created_at
			FROM
				$this->tabel_transaksi_detail
				LEFT JOIN $this->tabel_toko ON $this->tabel_toko.id = $this->tabel_transaksi_detail.toko_id
				LEFT JOIN $this->tabel ON $this->tabel_transaksi_detail.transaksi_id = $this->tabel.id
				LEFT JOIN $this->tabel_alamat ON $this->tabel.alamat_id=$this->tabel_alamat.id
				LEFT JOIN $this->tabel_kecamatan ON $this->tabel_alamat.kecamatan_id=$this->tabel_kecamatan.id
				LEFT JOIN $this->tabel_kabupaten ON $this->tabel_alamat.kabupaten_id=$this->tabel_kabupaten.id
				LEFT JOIN $this->tabel_provinsi ON $this->tabel_alamat.provinsi_id=$this->tabel_provinsi.id
			WHERE
				$this->tabel_transaksi_detail.user_id = '$user_id' 
				$where_status
				$where
		")->num_rows();

		if ($jumlah_data == 0) {
			$result['Error'] = true;
			$result['Message'] = "Belum ada pesanan";
			$result['wr'] = $where_status;
			goto output;
		}

		$config['jumlah_data'] = $jumlah_data;
		$config['limit'] = $limit;
		$config['page']	= $page;

		$pagination = $this->query_pagination($config);

		$pesanan = $this->db->query("SELECT
										$this->tabel_transaksi_detail.id,
										$this->tabel_transaksi_detail.transaksi_id,
										$this->tabel_transaksi_detail.toko_id,
										$this->tabel_toko.nama_toko AS toko_nama,
										$this->tabel_transaksi_detail.no_transaksi,
										$this->tabel.payment_metode,
										$this->tabel.payment_output,
										$this->tabel.no_invoice,
										$this->tabel.status,
										$this->tabel.total_bayar,
										$this->tabel.ppn,
										$this->tabel_transaksi_detail.kurir_resi,
										$this->tabel_transaksi_detail.kurir_code,
										$this->tabel_transaksi_detail.status as detail_status,
										$this->tabel_alamat.penerima_nama,
										$this->tabel_alamat.penerima_no_telepon,
										$this->tabel_alamat.alamat as alamat_penerima,
										$this->tabel_alamat.nama as alamat_penerima_nama,
										$this->tabel_kecamatan.nama as alamat_kecamatan_nama,
										$this->tabel_kabupaten.nama as alamat_kabupaten_nama,
										$this->tabel_provinsi.nama as alamat_provinsi_nama,
										$this->tabel.created_at
									FROM
										$this->tabel_transaksi_detail
										LEFT JOIN $this->tabel_toko ON $this->tabel_toko.id = $this->tabel_transaksi_detail.toko_id
										LEFT JOIN $this->tabel ON $this->tabel.id = $this->tabel_transaksi_detail.transaksi_id
										LEFT JOIN $this->tabel_alamat ON $this->tabel.alamat_id=$this->tabel_alamat.id
										LEFT JOIN $this->tabel_kecamatan ON $this->tabel_alamat.kecamatan_id=$this->tabel_kecamatan.id
										LEFT JOIN $this->tabel_kabupaten ON $this->tabel_alamat.kabupaten_id=$this->tabel_kabupaten.id
										LEFT JOIN $this->tabel_provinsi ON $this->tabel_alamat.provinsi_id=$this->tabel_provinsi.id
									WHERE
										$this->tabel_transaksi_detail.user_id = '$user_id' 
										$where_status
										$where
									ORDER BY
										$this->tabel.id DESC
									LIMIT
										$pagination[Data_ke],$limit")->result_array();

		$result['Error'] = false;
		$result['Message'] = "success.";
		$result['Pagination'] = $pagination;
		$no = 0;
		$expire = [];
		$log_dibatalkan = [];
		$sattlement = [];
		$log = [];
		foreach ($pesanan as $key) {
			// if ($key['detail_status'] == 3) {
			// 	$delivered = $this->ongkir->get_tracking(['no_resi' => $key['kurir_resi'],'courier_code' => $key['kurir_code']]);
			// 	if ($delivered['delivered']) {
			// 		$delivered_date = strtotime('+3 day',strtotime($delivered['delivery_status']['pod_date']));
			// 		if ($delivered_date <= strtotime(date('Y-m-d'))) {
			// 			$this->db->update($this->tabel_transaksi_detail,['status' => '4'],['no_transaksi' => $key['no_transaksi']]);
			// 		}
			// 	}
			// }

			if ($key['status'] == 0 && $key['payment_metode'] == "midtrans") {
				$status_pesanan = "Belum dibayar";
				$midtrans = $this->midtrans(array(
					"url" => $key['no_invoice']."/status"
				));

				if ($midtrans['transaction_status'] == "expire") {
					$expire[$no] = array(
						'status' => '2',
						'no_invoice' => $key['no_invoice']
					);

					$log_dibatalkan[$no] = array(
						'id' => $key['id'],
						'status' => '0',
						'log_dibatalkan' => date('Y-m-d H:i:s')
					);
				}else if ($midtrans['transaction_status'] == "settlement") {
					$sattlement[$no] = array(
						'status' => '1',
						'no_invoice' => $key['no_invoice']
					);

					$log[$no] = array(
						'expired_at' => date('Y-m-d H:i:s', strtotime("+".$this->get_maksimal_pengiriman()." days", strtotime(date('Y-m-d H:i:s')))),
						'transaksi_id' => $key['id']
					);
				}
			}else if ($key['status'] == 0) {
				$status_pesanan = "Belum dibayar";
			}else if ($key['status'] == 1) {
				$status_pesanan = "Dibayar";
			}else if ($key['status'] == 2) {
				$status_pesanan = "Dibatalkan";
			}

			if ($key['detail_status'] == 0) {
				$detail_status = "Dibatalkan";
			}else if ($key['detail_status'] == 1) {
				$detail_status = "Menunggu diproses";
			}else if ($key['detail_status'] == 2) {
				$detail_status = "Diproses";
			}else if ($key['detail_status'] == 3) {
				$detail_status = "Dikirim";
			}else if ($key['detail_status'] == 4) {
				$detail_status = "Diterima";
			}

			$data['id'] = $key['id'];
			$data['transaksi_id'] = $key['transaksi_id'];
			$data['toko_id'] = $key['toko_id'];
			$data['toko_nama'] = $key['toko_nama'];
			$data['no_transaksi'] = $key['no_transaksi'];
			$data['status'] = $status_pesanan;
			$data['detail_status'] = $detail_status;
			$data['no_invoice'] = $key['no_invoice'];
			$data['total_bayar'] = $key['total_bayar'] + $key['ppn'];
			$data['payment_metode'] = $key['payment_metode'];
			$data['payment_output'] = $key['payment_output'];
			$data['penerima_nama'] = $key['penerima_nama'];
			$data['penerima_no_telepon'] = $key['penerima_no_telepon'];
			$data['alamat_penerima'] = $key['alamat_penerima'];
			$data['alamat_penerima_nama'] = $key['alamat_penerima_nama'];
			$data['alamat_kecamatan_nama'] = $key['alamat_kecamatan_nama'];
			$data['alamat_kabupaten_nama'] = $key['alamat_kabupaten_nama'];
			$data['alamat_provinsi_nama'] = $key['alamat_provinsi_nama'];
			$data['tanggal'] = date('j M Y',strtotime($key['created_at']));
			$data['waktu'] = date('H:i',strtotime($key['created_at']));

			$result['Data'][$no++] = $data;
		}
		
		$this->db->update_batch($this->tabel, $expire, 'no_invoice');
		$this->db->update_batch($this->tabel_transaksi_detail, $log_dibatalkan, 'id');
		$this->db->update_batch($this->tabel, $sattlement, 'no_invoice');
		$this->db->update_batch($this->tabel_transaksi_log, $log, 'transaksi_id');

		output:
		return $result;
	}


	public function detail($params)
	{
		$client_token = $params['client_token'];
		$no_invoice = $params['no_invoice'];

		if (empty($client_token)) {
			$hasil = array(
				'Error' => true,
				'Message' => "Parameter 'client_token' tidak diset."
			);
			goto output;
		}else if (empty($no_invoice)) {
			$hasil = array(
				'Error' => true,
				'Message' => "Transaksi belum dipilih."
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

			$cek_transaksi = $this->db->query("
				SELECT
					id
				FROM
					$this->tabel
				WHERE
					no_invoice = '$no_invoice'
			");
			if ($cek_transaksi->num_rows() == 0) {
				$hasil = array(
					'Error' => true,
					'Message' => "Transaksi tidak ditemukan."
				);
				goto output;
			}

			$get_transaksi = $this->db->query("
				SELECT
					$this->tabel.id,
					$this->tabel.no_invoice,
					$this->tabel.payment_metode,
					$this->tabel.payment_nama,
					$this->tabel.payment_output,
					CONCAT('".base_url('')."', $this->tabel.payment_bukti) AS payment_bukti,
					$this->tabel.payment_kadaluarsa,
					$this->tabel.status,
					$this->tabel.total_bayar,
					$this->tabel.ppn,
					$this->tabel.alamat_id,
					$this->tabel.created_at,
					$this->tabel_alamat.nama AS alamat_nama,
					$this->tabel_alamat.penerima_nama AS alamat_penerima_nama,
					$this->tabel_alamat.penerima_no_telepon AS alamat_penerima_telepon,
					$this->tabel_alamat.provinsi_id AS alamat_provinsi_id,
					$this->tabel_provinsi.nama AS alamat_provinsi_nama,
					$this->tabel_alamat.kabupaten_id AS alamat_kabupaten_id,
					CONCAT($this->tabel_kabupaten.type, ' ', $this->tabel_kabupaten.nama) AS alamat_kabupaten_nama,
					$this->tabel_alamat.kecamatan_id AS alamat_kecamatan_id,
					$this->tabel_kecamatan.nama AS alamat_kecamatan_nama,
					$this->tabel_alamat.alamat AS alamat_detail
				FROM
					$this->tabel
					LEFT JOIN $this->tabel_alamat ON $this->tabel_alamat.id = $this->tabel.alamat_id
					LEFT JOIN $this->tabel_provinsi ON $this->tabel_provinsi.id = $this->tabel_alamat.provinsi_id
					LEFT JOIN $this->tabel_kabupaten ON $this->tabel_kabupaten.id = $this->tabel_alamat.kabupaten_id
					LEFT JOIN $this->tabel_kecamatan ON $this->tabel_kecamatan.id = $this->tabel_alamat.kecamatan_id
				WHERE 
					$this->tabel.no_invoice = '$no_invoice' AND
					$this->tabel.user_id = '$user_id'
			")->result_array();
			$no = 0;
			$hasil['Error'] = false;
			$hasil['Message'] = "success.";
			foreach ($get_transaksi as $key) {

				if ($key['status'] == 0) {
					$status = "Belum dibayar";

					if ($key['payment_metode'] == "midtrans") {
						$midtrans = $this->midtrans(array(
							"url" => $key['no_invoice']."/status"
						));

						if ($midtrans['transaction_status'] == "expire") {
							$this->db->update($this->tabel, array(
								'status' => '2'
							), array(
								'no_invoice' => $key['no_invoice']
							));

							$this->db->update($this->tabel_transaksi_detail, array(
								'log_dibatalkan' => date('Y-m-d H:i:s'),
								'status' => '0'
							), array(
								'no_invoice' => $key['no_invoice']
							));
						}else if ($midtrans['transaction_status'] == "settlement") {
							$this->db->update($this->tabel, array(
								'status' => '1',
								'log_dibayar' => date("Y-m-d H:i:s")
							), array(
								'no_invoice' => $key['no_invoice']
							));

							$this->db->update($this->tabel_transaksi_log, array(
								'dibayar' => date('Y-m-d H:i:s')
							), array(
								'transaksi_id' => $key['id']
							));

							$this->db->update($this->tabel_transaksi_detail, array(
								'expired_at' => date('Y-m-d H:i:s', strtotime("+".$this->get_maksimal_pengiriman()." days", strtotime(date('Y-m-d H:i:s'))))
							), array(
								'transaksi_id' => $key['id']
							));
						}
					}
				}else if ($key['status'] == 1) {
					$status = "Dibayar";
				}else if ($key['status'] == 2) {
					$status = "Dibatalkan";
				}

				$hasil['Data'][$no++] = array(
					'id' => $key['id'],
					'no_invoice' => $key['no_invoice'],
					'payment_metode' => $key['payment_metode'],
					'payment_nama' => $key['payment_nama'],
					'payment_output' => $key['payment_output'],
					'payment_bukti' => $key['payment_bukti'],
					'payment_kadaluarsa' => $key['payment_kadaluarsa'],
					'status' => $status,
					'ppn' => $key['ppn'],
					'total_bayar' => $key['total_bayar'] + $key['ppn'],
					'alamat_id' => $key['alamat_id'],
					'alamat_nama' => $key['alamat_nama'],
					'alamat_penerima_nama' => $key['alamat_penerima_nama'],
					'alamat_penerima_telepon' => $key['alamat_penerima_telepon'],
					'alamat_provinsi_id' => $key['alamat_provinsi_id'],
					'alamat_provinsi_nama' => $key['alamat_provinsi_nama'],
					'alamat_kabupaten_id' => $key['alamat_kabupaten_id'],
					'alamat_kabupaten_nama' => $key['alamat_kabupaten_nama'],
					'alamat_kecamatan_id' => $key['alamat_kecamatan_id'],
					'alamat_kecamatan_nama' => $key['alamat_kecamatan_nama'],
					'alamat_detail' => $key['alamat_detail'],
					'created_at' => $key['created_at'],
					'toko' => $this->get_toko($key['id'], $key['status'], $user_id)
				);
			}
			goto output;
		}

		output:
		return $hasil;
	}
	public function transaksi_detail($params)
	{
		$client_token = $params['client_token'];
		$no_invoice = $params['no_invoice'];
		$no_transaksi = $params['no_transaksi'];

		if (empty($client_token)) {
			$hasil = array(
				'Error' => true,
				'Message' => "Parameter 'client_token' tidak diset."
			);
			goto output;
		}else if (empty($no_invoice)) {
			$hasil = array(
				'Error' => true,
				'Message' => "Transaksi belum dipilih."
			);
			goto output;
		}else if (empty($no_transaksi)) {
			$hasil = array(
				'Error' => true,
				'Message' => "No. Transaksi belum diisi."
			);
			goto output;
		}else{

			$get_transaksi = $this->db->query("
				SELECT
					id
				FROM
					$this->tabel
				WHERE
					no_invoice = '$no_invoice'
			");

			if ($get_transaksi->num_rows() == 0) {
				$hasil = array(
					'Error' => true,
					'Message' => "Transaksi tidak ditemukan."
				);
				goto output;
			}

			foreach ($get_transaksi->result_array() as $key) {
				$transaksi_id = $key['id'];
			}

			$get_toko = $this->db->query("
				SELECT
					$this->tabel_transaksi_detail.toko_id,
					$this->tabel_transaksi_detail.no_transaksi,
					$this->tabel_transaksi_detail.status,
					$this->tabel_toko.logo AS toko_logo,
					$this->tabel_toko.nama_toko AS toko_nama,
					$this->tabel_toko.kabupaten_id AS toko_kabupaten_id,
					CONCAT($this->tabel_kabupaten.type, ' ', $this->tabel_kabupaten.nama) AS toko_kabupaten_nama
				FROM
					$this->tabel_transaksi_detail
					LEFT JOIN $this->tabel_toko ON $this->tabel_toko.id = $this->tabel_transaksi_detail.toko_id
					LEFT JOIN $this->tabel_kabupaten ON $this->tabel_kabupaten.id = $this->tabel_toko.kabupaten_id
				WHERE
					$this->tabel_transaksi_detail.no_transaksi = '$no_transaksi' AND
					$this->tabel_transaksi_detail.transaksi_id = '$transaksi_id'
			")->result_array();
			$no = 0;
			$hasil['Error'] = false;
			$hasil['Message'] = "success.";
			foreach ($get_toko as $key) {
				$hasil['Data'][$no++] = array(
					'no_transaksi' => $key['no_transaksi'],
					'toko_id' => $key['toko_id'],
					'toko_logo' => $key['toko_logo'],
					'toko_nama' => $key['toko_nama'],
					'toko_kabupaten_id' => $key['toko_kabupaten_id'],
					'toko_kabupaten_nama' => $key['toko_kabupaten_nama'],
					'produk' => $this->get_produk($transaksi_id, $key['toko_id'])
				);
			}
		}

		output:
		return $hasil;
	}

	public function upload_pembayaran($params)
	{
		$client_token = $params['client_token'];
		$no_invoice = $params['no_invoice'];
		$file = $params['file'];

		if (empty($client_token)) {
			$hasil = array(
				'Error' => true,
				'Message' => "Parameter 'client_token' tidak diset."
			);
			goto output;
		}else if (empty($no_invoice)) {
			$hasil = array(
				'Error' => true,
				'Message' => "Transaksi belum dipilih."
			);
			goto output;
		}else if (empty($file)) {
			$hasil = array(
				'Error' => true,
				'Message' => "File belum dipilih."
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

			$cek_transaksi = $this->db->query("
				SELECT
					id,
					payment_bukti
				FROM
					$this->tabel
				WHERE
					no_invoice = '$no_invoice'
			");

			if ($cek_transaksi->num_rows() == 0) {
				$hasil = array(
					'Error' => true,
					'Message' => "Transaksi tidak ditemukan."
				);
				goto output;
			}

			foreach ($cek_transaksi->result_array() as $key) {
				$new_image = $this->upload_image->upload($file, "Foto-pembayaran", 'payment', (empty($key['payment_bukti'])) ? "":$key['payment_bukti']);
			}

			$this->db->update($this->tabel, array(
				'payment_bukti' => $new_image['Url']
			), array(
				'user_id' => $user_id,
				'no_invoice' => $no_invoice
			));

			$hasil = array(
				'Error' => false,
				'Message' => "Bukti pembayaran berhasil diupload."
			);
			goto output;
		}

		output:
		return $hasil;
	}

	public function payment_manual()
	{
		$get_payment_manual = $this->db->query("
			SELECT
				content
			FROM
				$this->tabel_pembayaran_manual
			WHERE
				id = '1'
		")->result_array();
		$hasil['Error'] = false;
		$hasil['Message'] = "success.";
		$hasil['Data'] = array();
		foreach ($get_payment_manual as $key) {
			$hasil['Data'] = $key;
		}
		goto output;

		output:
		return $hasil;
	}
	
	
	public function komplain_add($params)
	{
		$client_token = isset($params['client_token'])? $params['client_token'] : '';
		$produk_id = isset($params['produk_id'])? $params['produk_id'] : '';
		$no_invoice = isset($params['no_invoice'])? $params['no_invoice'] : '';
		$komplain = isset($params['komplain'])? $params['komplain'] : '';
		if (empty($client_token)) {
			$result['Error'] = true;
			$result['Message'] = "Parameter client_token tidak diset";
			goto output;
		}else if(empty($produk_id)) {
			$result['Error'] = true;
			$result['Message'] = "Parameter produk_id tidak diset";
			goto output;
		}else if(empty($no_invoice)) {
			$result['Error'] = true;
			$result['Message'] = "Parameter no_invoice tidak diset";
			goto output;
		}else if(empty($komplain)) {
			$result['Error'] = true;
			$result['Message'] = "Komplain harus diisi";
			goto output;
		}

		$user_id = $this->get_user_id($client_token);

		if ($user_id == null) {
			$result = array(
				'Error' => true,
				'Message' => "Pengguna tidak ditemukan."
			);
			goto output;
		}

		$produk = $this->db->query("SELECT
		                                id,
		                                slug,
		                                toko_id
		                              FROM
		                                $this->tabel_produk
		                              WHERE
		                                   id = '$produk_id'")->row_array();
		if (!$produk) {
			$result = array(
				'Error' => true,
				'Message' => "Produk tidak ditemukan."
			);
			goto output;
		}

		$toko = $this->db->query("SELECT
										$this->tabel_toko.id,
										$this->tabel_toko.user_id,
										$this->tabel_user.nama as nama_penjual
									FROM
										$this->tabel_toko
									LEFT JOIN
										$this->tabel_user
										ON
										$this->tabel_toko.user_id=$this->tabel_user.id
									WHERE
										$this->tabel_toko.id='$produk[toko_id]'")->row_array();

		$transaksi = $this->db->query("SELECT
											id
										FROM
											$this->tabel
										WHERE
											no_invoice = '$no_invoice'")->row_array();
		if (!$transaksi) {
			$result = array(
				'Error' => true,
				'Message' => "Transaksi tidak ditemukan."
			);
			goto output;
		}

		

		$cek_komplain = $this->db->query("SELECT
												id
											FROM
												$this->tabel_komplain
											WHERE
												produk_id = '$produk[id]'
												AND user_id = '$user[id]'
												AND no_invoice = '$no_invoice'")->num_rows();
		$penjual_id = $toko['user_id'];
		$link = "seller/komplain";
		if ($cek_komplain == 0) {
			$data = [
    			'user_id' => $user_id,
    			'produk_id' => $produk['id'],
    			'no_invoice' => $no_invoice,
    			'transaksi_id' => $transaksi['id'],
    			'komplain' => $komplain
    		];
			$this->db->insert($this->tabel_komplain,$data);
			$notif = [
    			'user_id' => $penjual_id,
    			'tipe' => 'Komplain',
    			'link' => $link,
    			'konten' => "$toko[nama_penjual] komplain mengenai produk anda : $komplain"
    		];
			$this->Func->set_notif($notif);
			$result = array(
    			'Error' => false,
    			'Message' => "Berhasil komplain produk."
    		);
    		goto output;

		}

		$result = array(
			'Error' => true,
			'Message' => "Telah melakukan komplain."
		);
		goto output;
		output:
		return $result;

	}

	public function ulasan_add($params)
	{
		$client_token = isset($params['client_token'])? $params['client_token'] : '';
		$no_invoice = isset($params['no_invoice'])? $params['no_invoice'] : '';
		$toko_id = isset($params['toko_id'])? $params['toko_id'] : '';
		$produk_id = isset($params['produk_id'])? $params['produk_id'] : '';
		$rating = isset($params['rating'])? $params['rating'] : '';
		$ulasan = isset($params['ulasan'])? $params['ulasan'] : '';
		$foto = json_decode($params['foto'], true);

		if (empty($client_token)) {
			$result = array(
				'Error' => true,
				'Message' => "Parameter 'client_token' tidak diset."
			);
			goto output;
		}else if (empty($no_invoice)) {
			$result = array(
				'Error' => true,
				'Message' => "No. Invoice belum diisi."
			);
			goto output;
		}else if(empty($toko_id)) {
			$result = array(
				'Error' => true,
				'Message' => "Toko belum dipilih."
			);
			goto output;
		}else if (empty($produk_id)) {
			$result = array(
				'Error' => true,
				'Message' => "Produk belum dipilih."
			);
			goto output;
		}else if (empty($rating)) {
			$result = array(
				'Error' => true,
				'Message' => "Rating belum dipilih."
			);
			goto output;
		}

		$user = $this->db->query("SELECT
										id,
										nama
									FROM
										$this->tabel_user
									WHERE
										api_token = '$client_token'")->row_array();
		if (!$user) {
			$result['Error'] = true;
			$result['Message'] = "Pengguna tidak ditemukan";
			goto output;
		}

		$transaksi = $this->db->query("SELECT
											id
										FROM
											$this->tabel
										WHERE
											no_invoice = '$no_invoice'")->row_array();
		if (!$transaksi) {
			$result['Error'] = true;
			$result['Message'] = "Transaksi tidak ditemukan";
			goto output;
		}

		$produk = $this->db->query("SELECT
										id,
										toko_id,
										slug
									FROM
										$this->tabel_produk
									WHERE
										id = '$produk_id'")->row_array();
		if (!$produk) {
			$result['Error'] = true;
			$result['Message'] = "Produk tidak ditemukan";
			goto output;
		}

		$toko = $this->db->query("SELECT
										id,
										user_id,
										slug
									FROM
										$this->tabel_toko
										WHERE
										id = '$produk[toko_id]'")->row_array();
		if (!$toko) {
			$result['Error'] = true;
			$result['Message'] = "Toko tidak ditemukan";
			goto output;
		}

		$data_ulasan = $this->db->query("SELECT
										id,
										produk_id,
										user_id,
										rating,
										ulasan
									FROM
										$this->tabel_ulasan
									WHERE
										produk_id = '$produk[id]'
										AND
										user_id = '$user[id]'")->row_array();
		$data = [
			'toko_id' => $toko['id'],
			'produk_id' => $produk_id,
			'user_id' => $user['id'],
			'rating' => $rating,
			'ulasan' => $ulasan
		];
		if ($data_ulasan) {
			$ulasan_id = $data_ulasan['id'];
			$up = $this->db->update($this->tabel_ulasan,$data,['id' => $ulasan_id]);
			// if ($up) {
				$result['Error'] = false;
				$result['Message'] = "Berhasil mengubah ulasan";
				$notif = [
	    			'user_id' => $toko['user_id'],
	    			'tipe' => 'Ulasan',
	    			'link' => "seller/ulasan/",
	    			'konten' => "$user[nama] mengubah ulasan produk anda : $ulasan"
	    		];
				$this->Func->set_notif($notif);
			// }
		}else{
			$add = $this->db->insert($this->tabel_ulasan,$data);
			// if ($up) {
				$result['Error'] = false;
				$result['Message'] = "Berhasil menambah ulasan";

				$ulasan_id = $this->db->insert_id();
				$notif = [
	    			'user_id' => $toko['user_id'],
	    			'tipe' => 'Ulasan',
	    			'link' => "seller/ulasan/",
	    			'konten' => "$user[nama] mengulas produk anda : $ulasan"
	    		];
				$this->Func->set_notif($notif);
			// }
		}

		$cek_foto = $this->db->query("SELECT
										id
									FROM
										$this->tabel_ulasan_foto
									WHERE
										ulasan_id = '$ulasan_id'")->num_rows();
		if (($cek_foto + count($foto)) > 5) {
			$result['Error'] = true;
			$result['Message'] = "Foto sudah melampaui batas. Yaitu : 5";
			goto output;
		}

		if (count($foto) !== 0) {
			$no = 0;
			foreach ($foto as $key) {
				$foto_baru = $this->upload_image->upload($key['file'], "Foto-ulasan", 'ulasan');
				$new_foto[$no++] = [
					'produk_id' => $produk['id'],
					'ulasan_id' => $ulasan_id,
					'foto' => $foto_baru['Url']
				];
			}
			$this->db->insert_batch($this->tabel_ulasan_foto, $new_foto);
		}

		output:
		return $result;
	}

	public function ulasan($params)
	{
		$client_token = isset($params['client_token'])? $params['client_token'] : '';
		$produk_id = isset($params['produk_id'])? $params['produk_id'] : '';
		if (empty($client_token)) {
			$result['Error'] = true;
			$result['Message'] = "Parameter client_token tidak diset";
			goto output;
		}else if(empty($produk_id)) {
			$result['Error'] = true;
			$result['Message'] = "Parameter produk_id tidak diset";
			goto output;
		}

		$user = $this->db->query("SELECT
										id
									FROM
										$this->tabel_user
									WHERE
										api_token = '$client_token'")->row_array();
		if (!$user) {
			$result['Error'] = true;
			$result['Message'] = "Pengguna tidak ditemukan";
			goto output;
		}

		$produk = $this->db->query("SELECT
										id
									FROM
										$this->tabel_produk
									WHERE
										id = '$produk_id'")->row_array();
		if (!$produk) {
			$result['Error'] = true;
			$result['Message'] = "Produk tidak ditemukan";
			goto output;
		}

		$ulasan = $this->db->query("SELECT
										id,
										produk_id,
										user_id,
										rating,
										ulasan
									FROM
										$this->tabel_ulasan
									WHERE
										produk_id = '$produk_id'
										AND
										user_id = '$user[id]'")->row_array();
		if ($ulasan) {
			$result['Error'] = false;
			$result['Message'] = null;
			$result['Data'] = [
				'id' => $ulasan['id'],
				'produk_id' => $ulasan['produk_id'],
				'user_id' => $ulasan['user_id'],
				'rating' => $ulasan['rating'],
				'ulasan' => $ulasan['ulasan'],
				'foto' => $this->ulasan_foto($ulasan['produk_id'],$ulasan['id'])
			];
			goto output;
		}
		$result['Error'] = true;
		$result['Message'] = "Belum ada ulasan";
		$result['Data'] = null;
		goto output;
		output:
		return $result;

	}

	public function terima($params)
	{
		$client_token = $params['client_token'];
		$no_invoice = $params['no_invoice'];
		$no_transaksi = $params['no_transaksi'];

		if (empty($client_token)) {
			$hasil = array(
				'Error' => true,
				'Message' => "Parameter 'client_token' tidak diset."
			);
			goto output;
		}else if (empty($no_invoice)) {
			$hasil = array(
				'Error' => true,
				'Message' => "Parameter 'no_invoice' tidak diset."
			);
			goto output;
		}else if (empty($no_transaksi)) {
			$hasil = array(
				'Error' => true,
				'Message' => "Parameter 'no_transaksi' tidak diset."
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

			$cek_transaksi = $this->db->query("
				SELECT
					id,
					status
				FROM
					$this->tabel
				WHERE
					no_invoice = '$no_invoice'
			");

			if ($cek_transaksi->num_rows() == 0) {
				$hasil = array(
					'Error' => true,
					'Message' => "Transaksi tidak ditemukan."
				);
				goto output;
			}

			foreach ($cek_transaksi->result_array() as $key) {
				$transaksi_id = $key['id'];
				$transaksi_status = $key['status'];
			}

			$cek_pesanan = $this->db->query("
				SELECT
					id,
					status,
					toko_id
				FROM
					$this->tabel_transaksi_detail
				WHERE
					no_transaksi = '$no_transaksi' AND
					transaksi_id = '$transaksi_id'
			");

			if ($cek_pesanan->num_rows() == 0) {
				$hasil = array(
					'Error' => true,
					'Message' => "Pesanan tidak ditemukan."
				);
				goto output;
			}

			if ($transaksi_status == 0) {
				$hasil = array(
					'Error' => true,
					'Message' => "Transaksi belum dibayar."
				);
				goto output;
			}else if ($transaksi_status == 2) {
				$hasil = array(
					'Error' => true,
					'Message' => "Transaksi dibatalkan."
				);
				goto output;
			}

			foreach ($cek_pesanan->result_array() as $key) {
				$pesanan_toko_id = $key['toko_id'];

				if ($key['status'] == 1) {
					$hasil = array(
						'Error' => true,
						'Message' => "Pesanan menunggu diproses."
					);
					goto output;
				}else if ($key['status'] == 2) {
					$hasil = array(
						'Error' => true,
						'Message' => "Pesanan diproses."
					);
					goto output;
				}
			}

			$this->db->insert($this->tabel_transaksi_ajukan_pencairan, array(
				'transaksi_id' => $transaksi_id,
				'no_transaksi' => $no_transaksi,
				'toko_id' => $pesanan_toko_id
			));

			$this->db->update($this->tabel_transaksi_detail, array(
				'status' => '4',
				'log_diterima' => date('Y-m-d H:i:s')
			), array(
				'no_transaksi' => $no_transaksi,
				'transaksi_id' => $transaksi_id
			));

			$hasil = array(
				'Error' => false,
				'Message' => "Pesanan berhasil diterima."
			);
			$notif = [
    			'user_id' => $user_id,
    			'tipe' => 'Pembelian',
    			'link' => 'user/pembelian/detail/'.$no_invoice,
    			'konten' => "Pesanan telah diterima"
    		];
    		$this->Func->set_notif($notif);
			goto output;
		}

		output:
		return $hasil;
	}

	public function set_kurir($params)
	{
		$client_token = $params['client_token'];
		$toko_id = $params['toko_id'];
		$kurir = $params['kurir'];
		$kurir_code = $params['kurir_code'];
		$kurir_service = $params['kurir_service'];
		$kurir_etd = $params['kurir_etd'];
		$kurir_value = $params['kurir_value'];

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
		}else if (empty($kurir)) {
			$hasil = array(
				'Error' => true,
				'Message' => "Parameter 'kurir' tidak diset."
			);
			goto output;
		}else if (empty($kurir_code)) {
			$hasil = array(
				'Error' => true,
				'Message' => "Parameter 'kurir_code' tidak diset."
			);
			goto output;
		}else if (empty($kurir_service)) {
			$hasil = array(
				'Error' => true,
				'Message' => "Parameter 'kurir_service' tidak diset."
			);
			goto output;
		}else if (empty($kurir_value)) {
			$hasil = array(
				'Error' => true,
				'Message' => "Parameter 'kurir_value' tidak diset."
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
					id
				FROM
					$this->tabel_keranjang
				WHERE
					toko_id = '$toko_id' AND
					user_id = '$user_id'
			")->num_rows();

			if ($cek_toko == 0) {
				$hasil = array(
					'Error' => true,
					'Message' => "Toko tidak ditemukan."
				);
				goto output;
			}

			$this->db->update($this->tabel_keranjang, array(
				'user_id' => $user_id,
				'kurir' => $kurir,
				'kurir_code' => $kurir_code,
				'kurir_service' => $kurir_service,
				'kurir_etd' => $kurir_etd,
				'kurir_value' => $kurir_value
			), array(
				'toko_id' => $toko_id
			));

			$hasil = array(
				'Error' => false,
				'Message' => "Kurir berhasil diset."
			);
			goto output;
		}

		output:
		return $hasil;
	}

	public function cetak($params)
	{
		$client_token = $params['client_token'];
		$no_invoice = $params['no_invoice'];

		if (empty($client_token)) {
			$hasil = array(
				'status' => false,
				'message' => "Parameter 'client_token' tidak diset."
			);
			goto output;
		}else if (empty($no_invoice)) {
			$hasil = array(
				'status' => false,
				'message' => "Parameter 'no_invoice' tidak diset."
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

			$cek_transaksi = $this->db->query("
				SELECT
					$this->tabel.id,
					$this->tabel.no_invoice,
					$this->tabel.ppn,
					$this->tabel.status,
					$this->tabel_user.nama AS pembeli,
					$this->tabel_alamat.penerima_nama,
					$this->tabel_alamat.penerima_no_telepon,
					$this->tabel_alamat.provinsi_id,
					$this->tabel_provinsi.nama AS provinsi_nama,
					$this->tabel_alamat.kabupaten_id,
					CONCAT($this->tabel_kabupaten.type, ' ', $this->tabel_kabupaten.nama) AS kabupaten_nama,
					$this->tabel_alamat.kecamatan_id,
					$this->tabel_kecamatan.nama AS kecamatan_nama,
					$this->tabel_alamat.alamat,
					$this->tabel.created_at AS tgl_transaksi
				FROM
					$this->tabel
					LEFT JOIN $this->tabel_user ON $this->tabel_user.id = $this->tabel.user_id
					LEFT JOIN $this->tabel_alamat ON $this->tabel_alamat.id = $this->tabel.alamat_id
					LEFT JOIN $this->tabel_provinsi ON $this->tabel_provinsi.id = $this->tabel_alamat.provinsi_id
					LEFT JOIN $this->tabel_kabupaten ON $this->tabel_kabupaten.id = $this->tabel_alamat.kabupaten_id
					LEFT JOIN $this->tabel_kecamatan ON $this->tabel_kecamatan.id = $this->tabel_alamat.kecamatan_id
				WHERE
					$this->tabel.user_id = '$user_id' AND
					$this->tabel.no_invoice = '$no_invoice'
			");

			if ($cek_transaksi->num_rows() == 0) {
				$hasil = array(
					'status' => false,
					'message' => "Transaksi tidak ditemukan."
				);
				goto output;
			}

			$transaksi = $cek_transaksi->row_array();

			$transaksi_id = $transaksi['id'];
			$no_invoice = $transaksi['no_invoice'];
			$pembeli = $transaksi['pembeli'];
			$penerima_nama = $transaksi['penerima_nama'];
			$penerima_telepon = $transaksi['penerima_no_telepon'];
			$provinsi_id = $transaksi['provinsi_id'];
			$provinsi_nama = $transaksi['provinsi_nama'];
			$kabupaten_id = $transaksi['kabupaten_id'];
			$kabupaten_nama = $transaksi['kabupaten_nama'];
			$kecamatan_id = $transaksi['kecamatan_id'];
			$kecamatan_nama = $transaksi['kecamatan_nama'];
			$alamat = $transaksi['alamat'];
			$tgl_transaksi = $transaksi['tgl_transaksi'];

			if ($transaksi['status'] == 0) {
				$transaksi_status = "Belum dibayar";
			}else if ($transaksi['status'] = 1) {
				$transaksi_status = "Dibayar";
			}else if ($transaksi['status'] = 2) {
				$transaksi_status = "Dibatalkan";
			}

			$get_pesanan = $this->db->query("
				SELECT
					$this->tabel_transaksi_detail.no_transaksi,
					$this->tabel_transaksi_detail.kurir,
					$this->tabel_transaksi_detail.kurir_service,
					$this->tabel_transaksi_detail.kurir_resi,
					$this->tabel_transaksi_detail.kurir_etd,
					$this->tabel_transaksi_detail.kurir_value,
					$this->tabel_transaksi_detail.toko_id,
					$this->tabel_transaksi_detail.status,
					$this->tabel_toko.nama_toko,
					$this->tabel_toko.kabupaten_id,
					CONCAT($this->tabel_kabupaten.type, ' ', $this->tabel_kabupaten.nama) AS kabupaten_nama
				FROM
					$this->tabel_transaksi_detail
					LEFT JOIN $this->tabel_toko ON $this->tabel_toko.id = $this->tabel_transaksi_detail.toko_id
					LEFT JOIN $this->tabel_kabupaten ON $this->tabel_kabupaten.id = $this->tabel_toko.kabupaten_id
				WHERE
					$this->tabel_transaksi_detail.transaksi_id = '$transaksi_id'
			")->result_array();

			$get_produk = $this->db->query("
				SELECT
					$this->tabel_transaksi_produk.produk_id,
					$this->tabel_transaksi_produk.toko_id,
					$this->tabel_produk.nama_produk,
					$this->tabel_produk.sku_produk,
					$this->tabel_transaksi_produk.harga,
					$this->tabel_transaksi_produk.qty,
					$this->tabel_transaksi_produk.catatan
				FROM
					$this->tabel_transaksi_produk
					LEFT JOIN $this->tabel_produk ON $this->tabel_produk.id = $this->tabel_transaksi_produk.produk_id
				WHERE
					$this->tabel_transaksi_produk.transaksi_id = '$transaksi_id'
			")->result_array();

			$get_biaya_penanganan = $this->db->query("
				SELECT
					biaya
				FROM
					$this->tabel_biaya_admin
			")->row_array();;

			$biaya_penanganan = $get_biaya_penanganan['biaya'];

			$pesanan = [];
			$pesanan_no = 0;
			$subtotal_tagihan = 0;
			foreach ($get_pesanan as $key) {

				if ($key['status'] == 0) {
					$pesanan_status = "Dibatalkan";
				}else if ($key['status'] == 1) {
					$pesanan_status = "Menunggu diproses";
				}else if ($key['status'] == 2) {
					$pesanan_status = "Diproses";
				}else if ($key['status'] == 3) {
					$pesanan_status = "Dikirim";
				}else if ($key['status'] == 4) {
					$pesanan_status = "Diterima";
				}

				$produk = [];
				$produk_no = 0;

				$sub_total = $key['kurir_value'];

				$ppn = 0;

				$total_produk = 0;

				foreach ($get_produk as $key_produk) {
					if ($key_produk['toko_id'] == $key['toko_id']) {
						$produk[$produk_no++] = $key_produk;
						$sub_total += $key_produk['qty'] * $key_produk['harga'];
						$total_produk += $key_produk['qty'] * $key_produk['harga'];
					}
				}

				$ppn = ceil(($transaksi['ppn'] == 0) ? 0 : ($total_produk * 10) / 100);

				$subtotal = $sub_total + $ppn;

				$pesanan[$pesanan_no++] = [
					'no_transaksi' => $key['no_transaksi'],
					'kurir' => $key['kurir'],
					'kurir_service' => $key['kurir_service'],
					'kurir_resi' => $key['kurir_resi'],
					'kurir_etd' => $key['kurir_etd'],
					'kurir_value' => $key['kurir_value'],
					'nama_toko' => $key['nama_toko'],
					'kabupaten_id' => $key['kabupaten_id'],
					'kabupaten_nama' => $key['kabupaten_nama'],
					'subtotal_transaksi' => "$subtotal",
					'ppn' => $ppn,
					'status' => $pesanan_status,
					'produk' => $produk
				];

				$subtotal_tagihan += $subtotal;
			}

			$total_pembayaran = $subtotal_tagihan + $biaya_penanganan;

			$hasil = [
				'Error' => true,
				'Message' => 'success',
				'Data' => [
					'transaksi_id' => $transaksi_id,
					'no_invoice' => $no_invoice,
					'tgl_transaksi' => $tgl_transaksi,
					'status' => $transaksi_status,
					'pembeli' => $pembeli,
					'alamat_pengiriman' => [
						'penerima_nama' => $penerima_nama,
						'penerima_telepon' => $penerima_telepon,
						'provinsi_id' => $provinsi_id,
						'provinsi_nama'=> $provinsi_nama,
						'kabupaten_id' => $kabupaten_id,
						'kabupaten_nama' => $kabupaten_nama,
						'kecamatan_id' => $kecamatan_id,
						'kecamatan_nama' => $kecamatan_nama,
						'alamat' => $alamat
					],
					'pesanan' => $pesanan,
					'rincian_tagihan' => [
						'subtotal_tagihan' => "$subtotal_tagihan",
						'ppn' => $ppn,
						'biaya_penanganan' => "$biaya_penanganan",
						'total_pembayaran' => "$total_pembayaran"
					]
				]
			];
			goto output;
		}

		output:
		return $hasil;
	}
	
    function batal_pembelian($params)
	{
		$client_token = isset($params['client_token'])? $params['client_token'] : '';
		$no_invoice = isset($params['no_invoice'])? $params['no_invoice'] : '';
		if (empty($client_token)) {
			$result['Error'] = true;
			$result['Message'] = "Invalid token";
			goto output;
		}else if(empty($no_invoice)) {
			$result['Error'] = true;
			$result['Message'] = "No invoice kosong";
			goto output;
		}

		$user = $this->db->query("SELECT
										id
									FROM
										$this->tabel_user
									WHERE
										api_token = '$client_token'")->row_array();
		if (!$user) {
			$result['Error'] = true;
			$result['Message'] = "Pengguna tidak ditemukan";
			goto output;
		}
		$user_id = $user['id'];

		$transaksi = $this->db->query("SELECT
											id
										FROM
											$this->tabel
										WHERE
											user_id = '$user_id' 
											AND
											no_invoice = '$no_invoice'
											AND
											status = '0'")->row_array();
		if (!$transaksi) {
			$result['Error'] = true;
			$result['Message'] = "Pesanan tidak ditemukan";
			goto output;
		}

		$data = [
			'status' => '2'
		];

		$update = $this->db->update($this->tabel,$data,['id' => $transaksi['id']]);
		$this->db->update($this->tabel_transaksi_detail, array(
			'log_dibatalkan' => date("Y-m-d H:i:s"),
			'status' => '0'
		), array(
			'transaksi_id' => $transaksi['id']
		));
		

		if ($update) {
			$result['Error'] = false;
			$result['Message'] = "Berhasil membatalkan pesanan";
			$notif = [
    			'user_id' => $user_id,
    			'tipe' => 'Pembelian',
    			'link' => 'user/pembelian/detail/'.$no_invoice,
    			'konten' => 'Pesanan dibatalkan'
    		];
    		$this->Func->set_notif($notif);
			goto output;
		}
		$result['Error'] = true;
		$result['Message'] = "Gagal membatalkan pesanan";
		goto output;

		output:
		return $result;
 
	}
	
	function hapus_pembelian($params)
	{
	    $client_token = isset($params['client_token'])? $params['client_token'] : '';
		$no_invoice = isset($params['no_invoice'])? $params['no_invoice'] : '';
		if (empty($client_token)) {
			$result['Error'] = true;
			$result['Message'] = "Invalid token";
			goto output;
		}else if(empty($no_invoice)) {
			$result['Error'] = true;
			$result['Message'] = "No invoice kosong";
			goto output;
		}
		
		$user = $this->db->query("SELECT
										id
									FROM
										$this->tabel_user
									WHERE
										api_token = '$client_token'")->row_array();
		if (!$user) {
			$result['Error'] = true;
			$result['Message'] = "Pengguna tidak ditemukan";
			goto output;
		}
		$user_id = $user['id'];

		$transaksi = $this->db->query("SELECT
											id
										FROM
											$this->tabel
										WHERE
											user_id = '$user_id' 
											AND
											no_invoice = '$no_invoice'
											AND
											status = '2'")->row_array();
		if (!$transaksi) {
			$result['Error'] = true;
			$result['Message'] = "Pesanan tidak ditemukan";
			goto output;
		}

		$data = [
			'is_hapus' => 1
		];

		$update = $this->db->update($this->tabel,$data,['id' => $transaksi['id']]);

		if ($update) {
			$result['Error'] = false;
			$result['Message'] = "Berhasil menghapus pesanan";
			goto output;
		}
		$result['Error'] = true;
		$result['Message'] = "Gagal menghapus pesanan";
		goto output;

		output:
		return $result;
		
	}
	
	private function set_notif($data)
	{
	    $this->db->insert($this->tabel_notifikasi,$data);
	}

}
