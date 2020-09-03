<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_Transaksi extends MY_Model {

	protected $tabel = 'mst_transaksi';

	protected $tabel_transaksi_ajukan_pencairan = 'mst_transaksi_pengajuan_pencairan';

	protected $tabel_transaksi_detail = 'mst_transaksi_detail';

	protected $tabel_transaksi_log = 'mst_transaksi_log';

	protected $tabel_transaksi_produk = 'mst_transaksi_produk';

	protected $tabel_transaksi_pengaturan = 'mst_transaksi_pengaturan';

	protected $tabel_transaksi_refund = 'mst_transaksi_refund';

	protected $tabel_provinsi = 'mst_provinsi';

	protected $tabel_kabupaten = 'mst_kabupaten';

	protected $tabel_kecamatan = 'mst_kecamatan';

	protected $tabel_toko = 'mst_toko';

	protected $tabel_user = 'mst_user';

	protected $tabel_alamat = 'mst_alamat_pengiriman';

	protected $tabel_produk = 'mst_produk';

	protected $tabel_produk_foto = 'mst_produk_foto';

	protected $tabel_biaya_admin = 'mst_biaya_admin';
	
	protected $tabel_notifikasi = 'notifikasi';

	public function __construct()
	{
		parent::__construct();
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
				$this->tabel_transaksi_detail.transaksi_id = '$transaksi_id'
		")->result_array();
		$no = 0;
		$expired = [];
		$refund = [];
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

						$expired[$no] = array(
							'status' => '0',
							'log_dibatalkan' => date("Y-m-d H:i:s"),
							'no_transaksi' => $key['no_transaksi']
						);

						$refund[$no] = array(
							'transaksi_id' => $transaksi_id,
							'no_transaksi' => $key['no_transaksi'],
							'user_id' => $user_id,
						);
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

		$this->db->update_batch($this->tabel_transaksi_detail, $expired, 'no_transaksi');
		$this->db->insert_batch($this->tabel_transaksi_detail, $refund);

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
				'catatan' => $key['catatan']
			);
		}

		return $hasil;
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
		$start = $params['start'];
		$length = $params['length'];
		$draw = $params['draw'];
		$search = $params['search']['value'];
		$status = $params['status'];
		$payment = $params['payment'];

		$limit = ($start != "" && !empty($length)) ? "LIMIT $start, $length":"";
		$where = "WHERE $this->tabel.no_invoice LIKE '%$search%'";
		$where2 = '';
		if($status != "") {
			$where .= " AND $this->tabel.status = '$status'";
			$where2 .= " AND $this->tabel.status = '$status'";
		}

		if (!empty($payment)) {
			$where .= " AND $this->tabel.payment_metode = '$payment'";
			$where2 .= " AND $this->tabel.payment_metode = '$payment'";
		}

		$this->db->delete($this->tabel, array(
			'is_selesai' => 0
		));

		awal:

		$get_data = $this->db->query("
			SELECT
				$this->tabel.id,
				$this->tabel.no_invoice,
				$this->tabel.status,
				$this->tabel.total_bayar,
				$this->tabel.payment_metode,
				$this->tabel.payment_nama,
				$this->tabel.payment_output,
				CONCAT('".base_url('')."', $this->tabel.payment_bukti) AS payment_bukti,
				$this->tabel.payment_kadaluarsa,
				$this->tabel.user_id,
				$this->tabel.created_at
			FROM
				$this->tabel
			$where
			ORDER BY $this->tabel.id DESC
			$limit
		")->result_array();
		$no = 0;
		$hasil['Error'] = false;
		$hasil['Message'] = "success.";
		$hasil['Data'] = array();
		foreach ($get_data as $key) {
			$status = "Belum dibayar";
			if ($key['status'] == 0 && $key['payment_metode'] == "midtrans") {
				$status = "Belum dibayar";

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
						'status' => '0',
						'log_dibatalkan' => date("Y-m-d H:i:s")
					), array(
						'transaksi_id' => $key['id']
					));
					goto awal;
				}else if ($midtrans['transaction_status'] == "settlement") {
					$this->db->update($this->tabel, array(
						'status' => '1',
						'log_dibayar' => date('Y-m-d H:i:s')
					), array(
						'no_invoice' => $key['no_invoice']
					));

					$this->db->update($this->tabel_transaksi_detail, array(
						'expired_at' => date('Y-m-d H:i:s', strtotime("+".$this->get_maksimal_pengiriman()." days", strtotime(date('Y-m-d H:i:s'))))
					), array(
						'transaksi_id' => $key['id']
					));
					goto awal;
				}
			}else if ($key['status'] == 1) {
				$status = "Dibayar";
			}else if ($key['status'] == 2) {
				$status = "Dibatalkan";
			}

			$hasil['Data'][$no++] = array(
				'id' => $key['id'],
				'no_invoice' => $key['no_invoice'],
				'status' => $status,
				'total_bayar' => $key['total_bayar'],
				'payment_metode' => $key['payment_metode'],
				'payment_nama' => $key['payment_nama'],
				'payment_output' => $key['payment_output'],
				'payment_bukti' => $key['payment_bukti'],
				'payment_kadaluarsa' => $key['payment_kadaluarsa'],
				'user_id' => $key['user_id'],
				'created_at' => $key['created_at']
			);
		}
		$hasil['recordsTotal'] = $this->recordsTotal($this->tabel);
		$hasil['recordsFiltered'] = $this->recordsFiltered($this->tabel, 'id', "$this->tabel.no_invoice LIKE '%$search%' $where2");
		$hasil['draw'] = $draw;
		goto output;

		output:
		return $hasil;
	}

	public function verifikasi_pembayaran($params)
	{
		$no_invoice = $params['no_invoice'];

		if (empty($no_invoice)) {
			$hasil = array(
				'Error' => true,
				'Message' => "Transaksi belum dipilih."
			);
			goto output;
		}else{
			$cek_transaksi = $this->db->query("
				SELECT
					id,
					payment_bukti,
					user_id,
					no_invoice
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
				if ($key['payment_bukti'] == null) {
					$hasil = array(
						'Error' => true,
						'Message' => "Bukti pembayaran belum diupload."
					);
					goto output;
				}

				$this->db->update($this->tabel_transaksi_detail, array(
					'expired_at' => date('Y-m-d H:i:s', strtotime("+".$this->get_maksimal_pengiriman()." days", strtotime(date('Y-m-d H:i:s'))))
				), array(
					'transaksi_id' => $key['id']
				));
			}
			
			$transaksi = $cek_transaksi->row_array();

			$this->db->update($this->tabel, array(
				'status' => '1',
				'log_dibayar' => date('Y-m-d H:i:s')
			), array(
				'no_invoice' => $no_invoice
			));

			$hasil = array(
				'Error' => false,
				'Message' => "Transaksi berhasil dikonfirmasi."
			);
			$notif = [
    			'user_id' => $transaksi['user_id'],
    			'tipe' => 'Pembelian',
    			'link' => 'user/pembelian/detail/'.$transaksi['no_invoice'],
    			'konten' => "Pembayaran telah dikonfirmasi, Menunggu diproses"
    		];
    		$this->Func->set_notif($notif);
    		$this->set_notif_toko($transaksi['no_invoice']);
			goto output;
		}

		output:
		return $hasil;
	}

    private function set_notif_toko($no_invoice)
	{
		$transaksi = $this->db->query("SELECT
											id,
											user_id,
											no_invoice
										FROM
											$this->tabel
										WHERE
											no_invoice = '$no_invoice'")->row_array();
		if ($transaksi) {

			$tbl_detail = "$this->tabel_transaksi_detail";
			
			$detail = $this->db->query("SELECT
											$tbl_detail.id,
											$tbl_detail.toko_id,
											$tbl_detail.no_transaksi,
											$this->tabel_toko.user_id,
											$this->tabel_user.nama
										FROM
											$tbl_detail
										LEFT JOIN
											$this->tabel_toko
											ON
											$tbl_detail.toko_id = $this->tabel_toko.id
										LEFT JOIN 
											$this->tabel_user
											ON
											$this->tabel_toko.user_id=$this->tabel_user.id
										WHERE
											$tbl_detail.transaksi_id = '$transaksi[id]'
										")->result_array();
			foreach($detail as $key){
				$notif = [
	    			'user_id' => $key['user_id'],
	    			'tipe' => 'Pembelian',
	    			'link' => 'seller/penjualan/detail/'.$key['no_transaksi'],
	    			'konten' => "Pesanan menunggu diproses"
	    		];
	    		$this->Func->set_notif($notif);
			}
			return true;

		}
	}

	public function detail($params)
	{
		$no_invoice = $params['no_invoice'];

		if (empty($no_invoice)) {
			$hasil = array(
				'Error' => true,
				'Message' => "Transaksi belum dipilih."
			);
			goto output;
		}else{
			$cek_transaksi = $this->db->query("
				SELECT
					id,
					user_id
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
				$user_id = $key['user_id'];
			}

			awal:

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
					$this->tabel.no_invoice = '$no_invoice'
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
								'status' => '0',
								'log_dibatalkan' => date("Y-m-d H:i:s")
							), array(
								'transaksi_id' => $key['id']
							));
							goto awal;
						}else if ($midtrans['transaction_status'] == "settlement") {
							$this->db->update($this->tabel, array(
								'status' => '1',
								'log_dibayar' => date('Y-m-d H:i:s')
							), array(
								'no_invoice' => $key['no_invoice']
							));

							$this->db->update($this->tabel_transaksi_detail, array(
								'expired_at' => date('Y-m-d H:i:s', strtotime("+".$this->get_maksimal_pengiriman()." days", strtotime(date('Y-m-d H:i:s'))))
							), array(
								'transaksi_id' => $key['id']
							));
							goto awal;
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
					'created_at' => $key['created_at'],
					'status' => $status,
					'total_bayar' => $key['total_bayar'],
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
					'toko' => $this->get_toko($key['id'], $key['status'], $user_id)
				);
			}
			goto output;
		}

		output:
		return $hasil;
	}

	public function cetak($params)
	{
		$user_id = $params['user_id'];
		$no_invoice = $params['no_invoice'];

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

    private function set_notif($data)
	{
		$this->db->insert($this->tabel_notifikasi,$data);
	}

}

/* End of file Transaksi.php */
/* Location: ./application/models/Transaksi.php */