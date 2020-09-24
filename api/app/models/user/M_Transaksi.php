<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_Transaksi extends MY_Model {

	protected $tabel = "mst_transaksi";

	protected $tabel_detail = 'mst_transaksi_detail';

	protected $tabel_transaksi_produk = 'mst_transaksi_produk';

	protected $tabel_transaksi_log = 'mst_transaksi_log';

	protected $tabel_keranjang = 'mst_keranjang';

	protected $tabel_produk = 'mst_produk';

	protected $tabel_alamat = 'mst_alamat_pengiriman';

	protected $tabel_provinsi = 'mst_provinsi';

	protected $tabel_kabupaten = 'mst_kabupaten';

	protected $tabel_kecamatan = 'mst_kecamatan';

	protected $tabel_user = 'mst_user';

	protected $tabel_biaya_admin = 'mst_biaya_admin';
	
	protected $tabel_notifikasi = 'notifikasi';
	
	protected $tabel_toko = 'mst_toko';

	public function __construct()
	{
		parent::__construct();
		$this->load->library('Midtrans');
		if (env('MIDTRANS_ENV') == 'production') {
			$params = array('server_key' => env('MIDTRANS_SERVER_KEY'), 'production' => true);
		}else{
			$params = array('server_key' => env('MIDTRANS_SERVER_KEY'), 'production' => false);
		}
		$this->midtrans->config($params);
		$this->load->model('M_Ppn','ppn');
	}

	private function no_invoice()
	{
		return 'JPSTORE-'.date('ymdhis');
	}

	private function get_alamat_utama($user_id)
	{
		$get_alamat = $this->db->query("
			SELECT
				id
			FROM
				$this->tabel_alamat
			WHERE 
				is_utama = '1' AND
				user_id = '$user_id'
		")->row_array();

		return $get_alamat['id'];
	}

	private function get_produk($user_id)
	{
		$get_produk = $this->db->query("
			SELECT
				$this->tabel_keranjang.produk_id,
				$this->tabel_produk.nama_produk AS produk_nama,
				$this->tabel_produk.harga AS produk_harga,
				$this->tabel_produk.diskon,
				$this->tabel_produk.stok AS produk_stok,
				$this->tabel_keranjang.jumlah,
				$this->tabel_keranjang.catatan,
				$this->tabel_keranjang.toko_id,
				$this->tabel_keranjang.created_at,
				$this->tabel_keranjang.updated_at
			FROM
				$this->tabel_keranjang
				LEFT JOIN $this->tabel_produk ON $this->tabel_produk.id = $this->tabel_keranjang.produk_id
			WHERE
				$this->tabel_keranjang.checked = '1' AND
				$this->tabel_keranjang.user_id = '$user_id'
		")->result_array();

		$where_grosir = "";
		foreach ($get_produk as $key) {
			$where_grosir .= $key['produk_id'].",";
		}

		$grosir = [];
		if(!empty($where_grosir)) {
			$grosir = $this->db->query("
				SELECT
					produk_id,
					qty_min,
					qty_max,
					harga
				FROM
					$this->grosir
				WHERE
					produk_id IN (".rtrim($where_grosir, ',').")
			")->result_array();
		}

		$produk = [];
		$produk_no = 0;
		foreach ($get_produk as $key) {

			$harga = $key['produk_harga'];

			foreach ($grosir as $harga_grosir) {
				if($harga_grosir['produk_id'] == $key['produk_id'] && $key['jumlah'] >= $harga_grosir['qty_min'] && $key['jumlah'] <= $harga_grosir['qty_max']) {
					$harga = $harga_grosir['harga'];
				}
			}

			$produk[$produk_no++] = array(
				'produk_id' => $key['produk_id'],
				'produk_nama' => $key['produk_nama'],
				'produk_harga' => $harga,
				'diskon' => $key['diskon'],
				'produk_stok' => $key['produk_stok'],
				'jumlah' => $key['jumlah'],
				'catatan' => $key['catatan'],
				'toko_id' => $key['toko_id'],
				'created_at' => $key['created_at'],
				'updated_at' => $key['updated_at']
			);
		}

		return $get_produk;
	}

	private function get_kurir($user_id)
	{
		$get_kurir = $this->db->query("
			SELECT
				$this->tabel_keranjang.kurir,
				$this->tabel_keranjang.kurir_code,
				$this->tabel_keranjang.kurir_service,
				$this->tabel_keranjang.kurir_etd,
				$this->tabel_keranjang.kurir_value,
				$this->tabel_keranjang.toko_id
			FROM
				$this->tabel_keranjang
			WHERE
				$this->tabel_keranjang.checked = '1' AND
				$this->tabel_keranjang.user_id = '$user_id'
			GROUP BY $this->tabel_keranjang.toko_id
		")->result_array();

		return $get_kurir;
	}

	public function snap_token($params)
	{
		$client_token = $params['client_token'];
		$payment = $params['payment'];

		if (empty($client_token)) {
			$hasil = array(
				'Error' => true,
				'Message' => "Parameter 'client_token' tidak diset."
			);
			goto output;
		}else if (empty($payment)) {
			$hasil = array(
				'Error' => true,
				'Message' => "Metode pembayaran belum dipilih."
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

		$no_invoice = $this->no_invoice();

		$this->db->insert($this->tabel, array(
			'user_id' => $user_id,
			'no_invoice' => $no_invoice,
			'alamat_id' => $this->get_alamat_utama($user_id),
			'status' => '0',
			'payment_metode' => $payment,
			'is_selesai' => '1',
			'payment_kadaluarsa' => date('Y-m-d H:i:s', strtotime("+7 hours", strtotime(date('Y-m-d H:i:s'))))
		));

		$transaksi_id = $this->db->insert_id();

		$get_biaya_admin = $this->db->query("
			SELECT
				biaya
			FROM
				$this->tabel_biaya_admin
			WHERE
				id = '1'
		")->row_array();

		$total_bayar = $get_biaya_admin['biaya'];
		$items = array();
		$items[0] = array(
			'id' => 'all',
			'price' => $get_biaya_admin['biaya'],
			'quantity' => 1,
			'name' => "Biaya Penanganan"
		);

		$get_produk = $this->get_produk($user_id);
		$sub_total = 0;
		foreach ($get_produk as $key) {
			if ($key['diskon'] == 0) {
				$sub_total += $key['produk_harga'] * $key['jumlah'];
			}else{
				$sub_total += ($key['produk_harga'] - (($key['diskon']/100)*$key['produk_harga'])) * $key['jumlah'];
			}
		}
		
		$ppn = $this->ppn->cek_status();
		if ($ppn !== 0) {
			$ppn = ceil(($sub_total * $ppn) / 100);
		}

		$items[1] = array(
			'id' => 'ppn',
			'price' => $ppn,
			'quantity' => 1,
			'name' => "PPN 10%"
		);
		$no = 2;
		foreach ($this->get_kurir($user_id) as $key) {
			$toko_id = $key['toko_id'];

			$items[$no++] = array(
				'id' => 'kurir-'.$no,
				'price' => $key['kurir_value'],
				'quantity' => 1,
				'name' => $key['kurir']." (".$key['kurir_service'].")"
			);

			$no_transaksi = $toko_id.date('ymdhs');

			$this->db->insert($this->tabel_detail, array(
				'status' => '1',
				'transaksi_id' => $transaksi_id,
				'toko_id' => $toko_id,
				'user_id' => $user_id,
				'no_transaksi' => $no_transaksi,
				'kurir' => $key['kurir'],
				'kurir_service' => $key['kurir_service'],
				'kurir_etd' => $key['kurir_etd'],
				'kurir_value' => $key['kurir_value'],
				'kurir_code' => $key['kurir_code']
			));

			$total_bayar += $key['kurir_value'];
		}

		foreach ($get_produk as $produk_key) {
			if ($produk_key['produk_stok'] < $produk_key['jumlah']) {
				$hasil = array(
					'Error' => true,
					'Message' => "QTY produk melebihi jumlah stok, yaitu <b>".$produk_key['produk_stok']."</b>"
				);
				goto output;
			}

			if ($produk_key['diskon'] == 0) {
				$total_bayar += $produk_key['jumlah'] * $produk_key['produk_harga'];
			}else{
				$total_bayar += $produk_key['jumlah'] * ceil(($produk_key['produk_harga'] - (($produk_key['diskon']/100)*$produk_key['produk_harga'])));
			}

			if ($produk_key['diskon'] == 0) {
				$harga_produk = $produk_key['produk_harga'];
			}else{
				$harga_produk = ceil($produk_key['produk_harga'] - (($produk_key['diskon']/100)*$produk_key['produk_harga']));
			}

			$items[$no++] = array(
				'id' => $produk_key['produk_id'],
				'price' => $harga_produk,
				'quantity' => $produk_key['jumlah'],
				'name' => substr($produk_key['produk_nama'], 0, 50)
			);

			$this->db->insert($this->tabel_transaksi_produk, array(
				'transaksi_id' => $transaksi_id,
				'toko_id' => $produk_key['toko_id'],
				'produk_id' => $produk_key['produk_id'],
				'harga' => $harga_produk,
				'qty' => $produk_key['jumlah'],
				'catatan' => $produk_key['catatan']
			));
		}

		$get_user = $this->db->query("
			SELECT
				id,
				nama,
				email,
				no_telepon
			FROM
				$this->tabel_user
			WHERE
				id = '$user_id'
		")->row_array();

		$user_nama = explode(" ", $get_user['nama']);
		$user_nama_count = count($user_nama);
		$user_first_name = $user_nama[0];
		$user_last_name = '';
		for ($i=1; $i < $user_nama_count; $i++) { 
			if ($i == $user_nama_count - 1) {
				$user_last_name .= $user_nama[$i];
			}else{
				$user_last_name .= $user_nama[$i]." ";
			}
		}

		$user_email = $get_user['email'];
		$user_telepon = $get_user['no_telepon'];

		// Required
		$transaction_details = array(
		  'order_id' => $no_invoice,
		  'gross_amount' => $total_bayar + $ppn,
		);

		// Optional
		$item_details = $items;

		// Optional
		$customer_details = array(
		  'first_name'    => $user_first_name,
		  'last_name'     => $user_last_name,
		  'email'         => $user_email,
		  'phone'         => $user_telepon
		);

		$this->db->update($this->tabel, array(
			'total_bayar' => $total_bayar,
			'ppn' => $ppn
		), array(
			'id' => $transaksi_id
		));

        $credit_card['secure'] = true;

        $time = time();
        $custom_expiry = array(
            'start_time' => date("Y-m-d H:i:s O",$time),
            'unit' => 'minute', 
            'duration'  => 1440
        );
        
        $transaction_data = array(
            'transaction_details'=> $transaction_details,
            'item_details'       => $item_details,
            'customer_details'   => $customer_details,
            'credit_card'        => $credit_card,
            'expiry'             => $custom_expiry
        );

		$snapToken = $this->midtrans->getSnapToken($transaction_data);
		$hasil = array(
			'Error' => false,
			'Message' => 'success.',
			'Data' => array(
				'snapToken' => $snapToken,
				'transaksi_id' => $transaksi_id
			)
		);
		goto output;

		output:
		return $hasil;
	}

	public function selesai($params)
	{
		$client_token = $params['client_token'];
		$transaksi_id = $params['transaksi_id'];
		$payment_output = json_encode($params['payment_output']);
		$pay = $params['payment_output'];

		if (empty($client_token)) {
			$hasil = array(
				'Error' => true,
				'Message' => "Parameter 'client_token' tidak diset."
			);
			goto output;
		}else if (empty($transaksi_id)) {
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
					id,
					no_invoice
				FROM
					$this->tabel
				WHERE
					id = '$transaksi_id'
			");
			if ($cek_transaksi->num_rows() == 0) {
				$hasil = array(
					'Error' => true,
					'Message' => "Transaksi tidak ditemukan."
				);
				goto output;
			}
			
			$transaksi = $cek_transaksi->row_array();

			$get_produk = $this->db->query("
				SELECT
					produk_id
				FROM
					$this->tabel_transaksi_produk
				WHERE
					transaksi_id = '$transaksi_id'
			")->result_array();
			foreach ($get_produk as $key) {
				$this->db->delete($this->tabel_keranjang, array(
					'user_id' => $user_id,
					'produk_id' => $key['produk_id']
				));
			}

			$this->db->insert($this->tabel_transaksi_log, array(
				'transaksi_id' => $transaksi_id,
				'dibuat' => date('Y-m-d h:i:s')
			));

			$this->db->update($this->tabel, array(
				'is_selesai' => '1',
				'payment_output' => $payment_output
			), array(
				'user_id' => $user_id,
				'id' => $transaksi_id
			));

			$hasil = array(
				'Error' => false,
				'Message' => "Transaksi menunggu pembayaran.",
				'no_invoice' => $transaksi['no_invoice']
			);

			$konten = 'Menunggu dibayar, Segera lakukan pembayaran';

			if ($pay['payment'] !== 'manual') {
				$konten = "Menunggu diproses, Mohon menunggu konfirmasi dari penjual";
			}

			$notif = [
    			'user_id' => $user_id,
    			'tipe' => 'Pembelian',
    			'link' => 'user/pembelian/detail/'.$transaksi['no_invoice'],
    			'konten' => $konten
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

			$transaksi_id = $transaksi['id'];

			$tbl_detail = "$this->tabel_detail";
			
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
											$tbl_detail.transaksi_id = '$transaksi_id'
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

	public function status($params)
	{
		$client_token = $params['client_token'];
		$no_invoice = $params['no_invoice'];

		if (empty($client_token)) {
			$hasil = array(
				'Error' => true,
				'Message' => "Paremeter 'client_token' tidak diset."
			);
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

/* End of file M_Transaksi.php */
/* Location: ./application/models/M_Transaksi.php */