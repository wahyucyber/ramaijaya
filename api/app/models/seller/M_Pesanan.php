<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_Pesanan extends MY_Model {

	protected $tabel = 'mst_transaksi_detail';

	protected $tabel_detail = 'mst_transaksi_detail';

	protected $tabel_produk = 'mst_transaksi_produk';

	protected $tabel_transaksi_log = 'mst_transaksi_log';

	protected $tabel_transaksi = 'mst_transaksi';

	protected $tabel_transaksi_refund = 'mst_transaksi_refund';

	protected $tabel_transaksi_detail = 'mst_transaksi_detail';

	protected $tabel_transaksi_pengaturan = 'mst_transaksi_pengaturan';

	protected $tabel_transaksi_pengajuan_pencairan = 'mst_transaksi_pengajuan_pencairan';

	protected $tabel_toko = 'mst_toko';

	protected $tabel_mst_produk = 'mst_produk';

	protected $tabel_mst_produk_foto = 'mst_produk_foto';

	protected $tabel_user = 'mst_user';

	protected $tabel_alamat_pengiriman = 'mst_alamat_pengiriman';

	protected $tabel_provinsi = 'mst_provinsi';

	protected $tabel_kabupaten = 'mst_kabupaten';

	protected $tabel_kecamatan = 'mst_kecamatan';

	protected $tabel_biaya_admin = 'mst_biaya_admin';

    protected $tabel_notifikasi = 'notifikasi';
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('user/M_Transaksi', 'transaksi');
	}

	private function get_produk($transaksi_id, $toko_id)
	{
		$get_produk = $this->db->query("
			SELECT
				$this->tabel_produk.produk_id,
				$this->tabel_mst_produk.nama_produk AS produk_nama,
				$this->tabel_mst_produk.slug AS produk_slug,
				$this->tabel_mst_produk.berat AS produk_berat,
				$this->tabel_produk.harga,
				$this->tabel_produk.qty,
				$this->tabel_produk.catatan
			FROM
				$this->tabel_produk
				LEFT JOIN $this->tabel_mst_produk ON $this->tabel_mst_produk.id = $this->tabel_produk.produk_id
			WHERE
				$this->tabel_produk.toko_id = '$toko_id' AND
				$this->tabel_produk.transaksi_id = '$transaksi_id'
		")->result_array();
		$hasil = array();
		$no = 0;
		foreach ($get_produk as $key) {
			$hasil[$no++] = array(
				'produk_id' => $key['produk_id'],
				'produk_foto' => $this->get_produk_foto($key['produk_id']),
				'produk_nama' => $key['produk_nama'],
				'produk_berat' => $key['produk_berat'],
				'produk_slug' => $key['produk_slug'],
				'harga' => $key['harga'],
				'qty' => $key['qty'],
				'catatan' => $key['catatan']
			);
		}
		return $hasil;
	}

	private function get_produk_foto($produk_id)
	{
		$get_foto = $this->db->query("
			SELECT
				id,
				CONCAT('".base_url('')."', foto) AS foto
			FROM
				$this->tabel_mst_produk_foto
			WHERE
				produk_id = '$produk_id'
		")->result_array();
		$no = 0;
		$hasil = array();
		foreach ($get_foto as $key) {
			$hasil[$no++] = $key;
		}
		return $hasil;
	}

	private function get_alamat_pengiriman($transaksi_id, $user_id)
	{
		$get_alamat = $this->db->query("
			SELECT
				$this->tabel_transaksi.alamat_id,
				$this->tabel_alamat_pengiriman.nama,
				$this->tabel_alamat_pengiriman.penerima_nama,
				$this->tabel_alamat_pengiriman.penerima_no_telepon,
				$this->tabel_alamat_pengiriman.provinsi_id,
				$this->tabel_provinsi.nama AS provinsi_nama,
				$this->tabel_alamat_pengiriman.kabupaten_id,
				CONCAT($this->tabel_kabupaten.type, ' ', $this->tabel_kabupaten.nama) AS kabupaten_nama,
				$this->tabel_alamat_pengiriman.kecamatan_id,
				$this->tabel_kecamatan.nama AS kecamatan_nama,
				$this->tabel_alamat_pengiriman.alamat AS detail
			FROM
				$this->tabel_transaksi
				LEFT JOIN $this->tabel_alamat_pengiriman ON $this->tabel_alamat_pengiriman.id = $this->tabel_transaksi.alamat_id
				LEFT JOIN $this->tabel_provinsi ON $this->tabel_provinsi.id = $this->tabel_alamat_pengiriman.provinsi_id
				LEFT JOIN $this->tabel_kabupaten ON $this->tabel_kabupaten.id = $this->tabel_alamat_pengiriman.kabupaten_id
				LEFT JOIN $this->tabel_kecamatan ON $this->tabel_kecamatan.id = $this->tabel_alamat_pengiriman.kecamatan_id
			WHERE
				$this->tabel_transaksi.id = '$transaksi_id'
		")->result_array();
		$hasil = array();
		foreach ($get_alamat as $key) {
			$hasil = $key;
		}
		return $hasil;
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

	public function index($params)
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
		}else {
			$user_id = $this->get_user_id($client_token);

			if ($user_id == null) {
				$hasil = array(
					'Error' => true,
					'Message' => "User tidak ditemukan."
				);
				goto output;
			}

			awal:

			$get_toko = $this->db->query("
				SELECT
					id
				FROM
					$this->tabel_toko
				WHERE
					user_id = '$user_id'
			")->row_array();
			$toko_id = $get_toko['id'];

			$limit = ($start != "" && !empty($length)) ? "LIMIT $start, $length":"";
			$where = "WHERE $this->tabel.toko_id = '$toko_id' AND $this->tabel.no_transaksi LIKE '%$search%' AND $this->tabel_transaksi.status != '0'";

			$get_transaksi_toko = $this->db->query("
				SELECT
					$this->tabel.transaksi_id,
					$this->tabel_transaksi_pengajuan_pencairan.status AS status_pencairan,
					$this->tabel.created_at,
					$this->tabel_transaksi_pengajuan_pencairan.updated_at AS pencairan_tanggal
				FROM
					$this->tabel
					LEFT JOIN $this->tabel_transaksi_pengajuan_pencairan ON $this->tabel_transaksi_pengajuan_pencairan.no_transaksi = $this->tabel.no_transaksi
					LEFT JOIN $this->tabel_transaksi ON $this->tabel_transaksi.id = $this->tabel.transaksi_id
				$where
				ORDER BY $this->tabel.id DESC
				$limit
			")->result_array();
			$no = 0;
			$hasil['Error'] = false;
			$hasil['Message'] = "success.";
			$hasil['Data'] = array();
			foreach ($get_transaksi_toko as $key) {

				$get_transaksi = $this->db->query("
					SELECT
						$this->tabel_detail.no_transaksi,
						$this->tabel_detail.status,
						(
							SELECT
								$this->tabel_transaksi.user_id
							FROM
								$this->tabel_transaksi
							WHERE
								$this->tabel_transaksi.id = '$key[transaksi_id]'
						) AS transaksi_user_id,
						(
							SELECT
								$this->tabel_transaksi.payment_metode
							FROM
								$this->tabel_transaksi
							WHERE
								$this->tabel_transaksi.id = '$key[transaksi_id]'
						) AS transaksi_payment_metode,
						(
							SELECT
								$this->tabel_transaksi.status
							FROM
								$this->tabel_transaksi
							WHERE
								$this->tabel_transaksi.id = '$key[transaksi_id]'
						) AS transaksi_status,
						(
							SELECT
								$this->tabel_transaksi.no_invoice
							FROM
								$this->tabel_transaksi
							WHERE
								$this->tabel_transaksi.id = '$key[transaksi_id]'
						) AS no_invoice,
						$this->tabel_detail.kurir,
						$this->tabel_detail.kurir_service,
						$this->tabel_detail.kurir_resi,
						$this->tabel_detail.kurir_etd,
						$this->tabel_detail.kurir_value,
						$this->tabel_detail.expired_at,
						(
							SELECT 
								SUM($this->tabel_produk.harga * $this->tabel_produk.qty) 
							FROM 
								$this->tabel_produk 
							WHERE 
								$this->tabel_produk.toko_id = '$toko_id' AND
								$this->tabel_produk.transaksi_id = '$key[transaksi_id]'
						) + $this->tabel_detail.kurir_value AS total_transaksi
					FROM
						$this->tabel_detail
					WHERE
						$this->tabel_detail.toko_id = '$toko_id' AND
						$this->tabel_detail.transaksi_id = '$key[transaksi_id]'
				")->row_array();

				$status = "Menunggu pembayaran";

				if ($get_transaksi['transaksi_status'] == 1 || $get_transaksi['transaksi_status'] == 2) {
					if ($get_transaksi['status'] == 1) {
						$status = "Menunggu diproses";
					}else if ($get_transaksi['status'] == 2) {
						$status = "Diproses";
					}else if ($get_transaksi['status'] == 3) {
						$status = "Dikirim";
					}else if ($get_transaksi['status'] == 4) {
						$status = "Selesai";
					}else if ($get_transaksi['status'] == 0) {
						$status = "Dibatalkan";
					}

					if ($get_transaksi['status'] == 1 || $get_transaksi['status'] == 2) {
						$waktu_awal = strtotime($get_transaksi['expired_at']);
						$waktu_sekarang = strtotime(date('Y-m-d H:i:s'));

						if ($waktu_awal < $waktu_sekarang) {
							$this->db->update($this->tabel_transaksi_detail, array(
								'status' => '0',
								'log_dibatalkan' => date('Y-m-d H:i:s')
							), array(
								'transaksi_id' => $key['transaksi_id'],
								'no_transaksi' => $get_transaksi['no_transaksi'],
								'toko_id' => $toko_id
							));

							$this->db->insert($this->tabel_transaksi_refund, array(
								'transaksi_id' => $key['transaksi_id'],
								'no_transaksi' => $get_transaksi['no_transaksi'],
								'user_id' => $get_transaksi['transaksi_user_id']
							));

							goto awal;
						}
					}
				}else{
					if ($get_transaksi['transaksi_payment_metode'] == "midtrans") {
						$midtrans = $this->midtrans(array(
							"url" => $get_transaksi['no_invoice']."/status"
						));

						if ($midtrans['transaction_status'] == "expire") {
							$this->db->update($this->tabel_transaksi, array(
								'status' => '2'
							), array(
								'no_invoice' => $get_transaksi['no_invoice']
							));

							$this->db->update($this->tabel_transaksi_detail, array(
								'status' => '0',
								'log_dibatalkan' => date('Y-m-d H:i:s')
							), array(
								'transaksi_id' => $key['transaksi_id']
							));
							
							goto awal;
						}else if ($midtrans['transaction_status'] == "settlement") {
							$this->db->update($this->tabel_transaksi, array(
								'status' => '1',
								'log_dibayar' => date("Y-m-d H:i:s")
							), array(
								'no_invoice' => $get_transaksi['no_invoice']
							));

							$this->db->update($this->tabel_transaksi_detail, array(
								'expired_at' => date('Y-m-d H:i:s', strtotime("+".$this->get_maksimal_pengiriman()." days", strtotime(date('Y-m-d H:i:s'))))
							), array(
								'transaksi_id' => $key['transaksi_id']
							));
							goto awal;
						}
					}
				}

				if ($key['status_pencairan'] == 0) {
					$status_pencairan = "Belum ditransfer";
				}else if ($key['status_pencairan'] == 1) {
					$status_pencairan = "Ditransfer";
				}else{
					$status_pencairan = "Belum ditransfer";
				}

				$hasil['Data'][$no++] = array(
					'no_transaksi' => $get_transaksi['no_transaksi'],
					'status' => $status,
					'status_pencairan' => $status_pencairan,
					'status_pencairan_tanggal' => $key['pencairan_tanggal'],
					'kurir' => $get_transaksi['kurir'],
					'kurir_service' => $get_transaksi['kurir_service'],
					'kurir_resi' => $get_transaksi['kurir_resi'],
					'kurir_etd' => $get_transaksi['kurir_etd'],
					'kurir_value' => $get_transaksi['kurir_value'],
					'total_transaksi' => $get_transaksi['total_transaksi'],
					'created_at' => $key['created_at']
				);
			}
			$hasil['recordsTotal'] = $this->recordsTotal($this->tabel." LEFT JOIN $this->tabel_transaksi ON $this->tabel_transaksi.id = $this->tabel.transaksi_id WHERE $this->tabel.toko_id = '$toko_id' AND $this->tabel_transaksi.status != '0'", "$this->tabel.id");
			$hasil['recordsFiltered'] = $this->recordsFiltered($this->tabel." LEFT JOIN $this->tabel_transaksi ON $this->tabel_transaksi.id = $this->tabel.transaksi_id ", "$this->tabel.id", "$this->tabel.toko_id = '$toko_id' AND $this->tabel.no_transaksi LIKE '%$search%' AND $this->tabel_transaksi.status != '0'");
			$hasil['draw'] = $draw;
			goto output;
		}

		output:
		return $hasil;
	}

	public function detail($params)
	{
		$client_token = $params['client_token'];
		$no_transaksi = $params['no_transaksi'];

		if (empty($client_token)) {
			$hasil = array(
				'Error' => true,
				'Message' => "Parameter 'client_token' tidak diset."
			);
			goto output;
		}else if (empty($no_transaksi)) {
			$hasil = array(
				'Error' => true,
				'Message' => "Transaksi belum dipilih."
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

			$get_toko = $this->db->query("
				SELECT
					id,
					slug
				FROM
					$this->tabel_toko
				WHERE
					user_id = '$user_id'
			")->row_array();
			$toko_id = $get_toko['id'];
			$toko_slug = $get_toko['slug'];

			$get_transaksi = $this->db->query("
				SELECT
					$this->tabel.id,
					$this->tabel.transaksi_id
				FROM
					$this->tabel
				WHERE
					$this->tabel.no_transaksi = '$no_transaksi' AND
					$this->tabel.toko_id = '$toko_id'
			")->row_array();
			$transaksi_id = $get_transaksi['transaksi_id'];

			$transaksi = $this->db->query("
				SELECT
					status
				FROM
					$this->tabel_transaksi
				WHERE
					id = '$transaksi_id'
			")->row_array();
			$transaksi_status = $transaksi['status'];

			$get_detail = $this->db->query("
				SELECT
					$this->tabel_detail.no_transaksi,
					$this->tabel_detail.status,
					$this->tabel_detail.kurir,
					$this->tabel_detail.kurir_service,
					$this->tabel_detail.kurir_resi,
					$this->tabel_detail.kurir_code,
					$this->tabel_detail.kurir_etd,
					$this->tabel_detail.kurir_value,
					$this->tabel_detail.expired_at,
					$this->tabel_detail.log_diproses,
					$this->tabel_detail.log_dikirim,
					$this->tabel_detail.log_diterima,
					$this->tabel_detail.created_at,
					(
						SELECT  
							no_invoice
						FROM 
							$this->tabel_transaksi
						WHERE
							id = '$transaksi_id'
					) AS no_invoice,
					(
						SELECT  
							payment_metode
						FROM 
							$this->tabel_transaksi
						WHERE
							id = '$transaksi_id'
					) AS payment_metode,
					(
						SELECT  
							payment_nama
						FROM 
							$this->tabel_transaksi
						WHERE
							id = '$transaksi_id'
					) AS payment_nama,
					(
						SELECT  
							payment_output
						FROM 
							$this->tabel_transaksi
						WHERE
							id = '$transaksi_id'
					) AS payment_output,
					(
						SELECT  
							user_id
						FROM 
							$this->tabel_transaksi
						WHERE
							id = '$transaksi_id'
					) AS user_id,
					(
						SELECT  
							$this->tabel_user.nama
						FROM 
							$this->tabel_transaksi
							LEFT JOIN $this->tabel_user ON $this->tabel_user.id = $this->tabel_transaksi.user_id
						WHERE
							$this->tabel_transaksi.id = '$transaksi_id'
					) AS user_nama,
					(SELECT SUM($this->tabel_produk.harga * $this->tabel_produk.qty) FROM $this->tabel_produk WHERE $this->tabel_produk.toko_id = '$toko_id' AND $this->tabel_produk.transaksi_id = '$transaksi_id') + $this->tabel_detail.kurir_value AS total_transaksi
				FROM
					$this->tabel_detail
				WHERE
					$this->tabel_detail.toko_id = '$toko_id' AND
					$this->tabel_detail.no_transaksi = '$no_transaksi' AND
					$this->tabel_detail.transaksi_id = '$transaksi_id'
			")->result_array();
			$hasil['Error'] = false;
			$hasil['Message'] = "success.";
			$hasil['Data'] = array(
				'no_transaksi' => $this->db->last_query()
			);
			foreach ($get_detail as $key) {
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
								'transaksi_id' => $transaksi_id,
								'no_transaksi' => $no_transaksi,
								'toko_id' => $toko_id
							));

							$this->db->insert($this->tabel_transaksi_refund, array(
								'transaksi_id' => $transaksi_id,
								'no_transaksi' => $no_transaksi,
								'user_id' => $key['user_id']
							));

							goto awal;
						}
					}
				}

				if ($transaksi_status == 0) {
					$status_transaksi = "Menunggu pembayaran";

					if ($key['payment_metode'] == "midtrans") {
						$midtrans = $this->midtrans(array(
							"url" => $key['no_invoice']."/status"
						));

						if ($midtrans['transaction_status'] == "expire") {
							$this->db->update($this->tabel_transaksi_detail, array(
								'status' => '0',
								'log_dibatalkan' => date("Y-m-d H:i:s")
							), array(
								'transaksi_id' => $transaksi_id,
								'no_transaksi' => $no_transaksi,
								'toko_id' => $toko_id
							));
							
							$this->db->update($this->tabel_transaksi, array(
								'status' => '2'
							), array(
								'no_invoice' => $key['no_invoice']
							));
							goto awal;
						}else if ($midtrans['transaction_status'] == "settlement") {
							$this->db->update($this->tabel_transaksi, array(
								'status' => '1',
								'log_dibayar' => date("Y-m-d H:i:s")
							), array(
								'no_invoice' => $key['no_invoice']
							));

							$this->db->update($this->tabel_transaksi_detail, array(
								'expired_at' => date('Y-m-d H:i:s', strtotime("+".$this->get_maksimal_pengiriman()." days", strtotime(date('Y-m-d H:i:s'))))
							), array(
								'transaksi_id' => $transaksi_id
							));
							goto awal;
						}
					}
				}else if ($transaksi_status == 1) {
					$status_transaksi = "Dibayar";
				}else if ($transaksi_status == 2) {
					$status_transaksi = "Dibatalkan";
				}

				$hasil['Data'] = array(
					'no_invoice' => $key['no_invoice'],
					'no_transaksi' => $key['no_transaksi'],
					'status' => $status,
					'status_transaksi' => $status_transaksi,
					'user_id' => $key['user_id'],
					'user_nama' => $key['user_nama'],
					'user_alamat' => $this->get_alamat_pengiriman($transaksi_id, $key['user_id']),
					'toko_slug' => $toko_slug,
					'payment_metode' => $key['payment_metode'],
					'payment_nama' => $key['payment_nama'],
					'payment_output' => $key['payment_output'],
					'kurir' => $key['kurir'],
					'kurir_service' => $key['kurir_service'],
					'kurir_resi' => $key['kurir_resi'],
					'kurir_code' => $key['kurir_code'],
					'kurir_etd' => $key['kurir_etd'],
					'kurir_value' => $key['kurir_value'],
					'total_transaksi' => $key['total_transaksi'],
					'expired_at' => $key['expired_at'],
					'log_diproses' => $key['log_diproses'],
					'log_dikirim' => $key['log_dikirim'],
					'log_diterima' => $key['log_diterima'],
					'created_at' => $key['created_at'],
					'produk' => $this->get_produk($transaksi_id, $toko_id)
				);
			}
		}

		output:
		return $hasil;
	}

	public function proses($params)
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
			$user_id = $this->get_user_id($client_token);

			if ($user_id == null) {
				$hasil = array(
					'Error' => true,
					'Message' => "User tidak ditemukan."
				);
				goto output;
			}

			$get_transaksi = $this->db->query("
				SELECT
					id,
					user_id
				FROM
					$this->tabel_transaksi
				WHERE
					no_invoice = '$no_invoice'
			")->row_array();

            $pembeli_id = $get_transaksi['user_id'];

			$transaksi_id = $get_transaksi['id'];

			$cek_transaksi = $this->db->query("
				SELECT
					id,
					toko_id
				FROM
					$this->tabel_detail
				WHERE
					no_transaksi = '$no_transaksi' AND
					transaksi_id = '$transaksi_id'
			");

			if ($cek_transaksi->num_rows() == 0) {
				$hasil = array(
					'Error' => true,
					'Message' => "Transaksi tidak ditemukan."
				);
				goto output;
			}

			foreach ($cek_transaksi->result_array() as $key) {
				$toko_id = $key['toko_id'];
			}

			$get_produk_beli = $this->db->query("
				SELECT
					$this->tabel_produk.produk_id,
					($this->tabel_mst_produk.stok - $this->tabel_produk.qty) AS stok_total
				FROM
					$this->tabel_produk
					LEFT JOIN $this->tabel_mst_produk ON $this->tabel_mst_produk.id = $this->tabel_produk.produk_id
				WHERE
					$this->tabel_produk.toko_id = '$toko_id' AND
					$this->tabel_produk.transaksi_id = '$transaksi_id'
			")->result_array();
			foreach ($get_produk_beli as $key) {

				$this->db->update($this->tabel_mst_produk, array(
					'stok' => $key['stok_total']
				), array(
					'id' => $key['produk_id'],
					'toko_id' => $toko_id
				));
			}

			$this->db->update($this->tabel_detail, array(
				'status' => '2',
				'log_diproses' => date('Y-m-d H:i:s')
			), array(
				'transaksi_id' => $transaksi_id,
				'no_transaksi' => $no_transaksi
			));

			$hasil = array(
				'Error' => false,
				'Message' => "Status pesanan berhasil diperbarui."
			);
			$notif = [
    			'user_id' => $user_id,
    			'tipe' => 'Pembelian',
    			'link' => 'seller/penjualan/detail/'.$no_transaksi,
    			'konten' => "Pesananan berhasil diproses"
    		];
    		$this->Func->set_notif($notif);
    		
    		$notif = [
    			'user_id' => $pembeli_id,
    			'tipe' => 'Pembelian',
    			'link' => 'user/pembelian/detail/'.$no_invoice,
    			'konten' => "Pesanan telah diproses"
    		];
    		$this->Func->set_notif($notif);
			goto output;
		}

		output:
		return $hasil;
	}

	public function kirim($params)
	{
		$client_token = $params['client_token'];
		$no_invoice = $params['no_invoice'];
		$no_transaksi = $params['no_transaksi'];
		$no_resi = $params['no_resi'];

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
		}else if (empty($no_resi)) {
			$hasil = array(
				'Error' => true,
				'Message' => "No. RESI belum diisi."
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

			$get_transaksi = $this->db->query("
				SELECT
					id,
					user_id
				FROM
					$this->tabel_transaksi
				WHERE
					no_invoice = '$no_invoice'
			")->row_array();

            $pembeli_id = $get_transaksi['user_id'];

			$transaksi_id = $get_transaksi['id'];

			$this->db->update($this->tabel_detail, array(
				'kurir_resi' => $no_resi,
				'status' => '3',
				'log_dikirim' => date('Y-m-d H:i:s')
			), array(
				'transaksi_id' => $transaksi_id,
				'no_transaksi' => $no_transaksi
			));

			$hasil = array(
				'Error' => false,
				'Message' => "Status transaksi berhasil diperbarui."
			);
			$notif = [
    			'user_id' => $user_id,
    			'tipe' => 'Pembelian',
    			'link' => 'seller/penjualan/detail/'.$no_transaksi,
    			'konten' => "Pesananan berhasil dikirim"
    		];
    		$this->Func->set_notif($notif);
    		
    		$notif = [
    			'user_id' => $pembeli_id,
    			'tipe' => 'Pembelian',
    			'link' => 'user/pembelian/detail/'.$no_invoice,
    			'konten' => "Pesanan sedang dikirim"
    		];
    		$this->Func->set_notif($notif);
			goto output;
		}

		output:
		return $hasil;
	}

	public function cetak($params)
	{
		$user_id = $params['user_id'];
		$no_invoice = $params['no_invoice'];
		$no_transaksi = $params['no_transaksi'];

		if (empty($user_id)) {
			$hasil = array(
				'status' => false,
				'message' => "Parameter 'user_id' tidak diset."
			);
			goto output;
		}else if (empty($no_invoice)) {
			$hasil = array(
				'status' => false,
				'message' => "Parameter 'no_invoice' tidak diset."
			);
			goto output;
		}else if (empty($no_transaksi)) {
			$hasil = array(
				'status' => false,
				'message' => "Parameter 'no_transaksi' tidak diset."
			);
			goto output;
		}else{

			$cek_user = $this->db->query("
				SELECT
					id
				FROM
					$this->tabel_user
				WHERE
					id = '$user_id'
			")->num_rows();

			if ($cek_user == 0) {
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
					user_id = '$user_id' AND
					no_invoice = '$no_invoice'
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
					$this->tabel_transaksi_detail.no_transaksi = '$no_transaksi' AND
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

    private function set_notif($data)
	{
		$this->db->insert($this->tabel_notifikasi,$data);
	}

}

/* End of file M_Pesanan.php */
/* Location: ./application/models/M_Pesanan.php */