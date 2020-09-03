<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_Dashboard extends MY_Model
{
	/**
	* @author          Masteguh
	* @link            https://github.com/AnteikuDevs
	*/
    protected $tabel_transaksi = 'mst_transaksi';

	 protected $tabel_transaksi_detail = 'mst_transaksi_detail';
	 
    protected $tabel_transaksi_produk = 'mst_transaksi_produk';

    protected $tabel_ulasan = 'mst_produk_ulasan';

    protected $tabel_komplain = 'mst_produk_komplain';

    protected $tabel_user = 'mst_user';

    protected $tabel_toko = 'mst_toko';

    protected $tabel_produk = 'mst_produk';

    protected $tabel_alamat = 'mst_alamat_pengiriman';

	protected $tabel_provinsi = 'mst_provinsi';

	protected $tabel_kabupaten = 'mst_kabupaten';

	protected $tabel_kecamatan = 'mst_kecamatan';

    function all($params)
    {
    	$params = __hsp($params);
    	$client_token = isset($params['client_token'])? $params['client_token'] : '';
    	if (empty($client_token)) {
    		$result['Error'] = true;
    		$result['Message'] = "Parameter client_token tidak diset";
    		goto output;
    	}

    	$user = $this->db->query("SELECT
    									$this->tabel_toko.id
    								FROM
    									$this->tabel_toko
									LEFT JOIN
										$this->tabel_user
										ON $this->tabel_toko.user_id=$this->tabel_user.id
    								WHERE
    									$this->tabel_user.api_token = '$client_token'")->row_array();
    	if (!$user) {
    		$result['Error'] = true;
    		$result['Message'] = "Pengguna tidak ditemukan";
    		goto output;
    	}

    	$toko_id = $user['id'];

    	$total_ulasan = $this->db->query("SELECT
    											COUNT(id) as total
    										FROM
    											$this->tabel_ulasan
    										WHERE
    											toko_id = '$toko_id'")->row_array()['total'];
    	$total_komplain = $this->db->query("SELECT
    											COUNT($this->tabel_komplain.id) as total
    										FROM
    											$this->tabel_komplain
    										LEFT JOIN
    											$this->tabel_produk
    											ON $this->tabel_komplain.produk_id=$this->tabel_produk.id
    										WHERE
    											$this->tabel_produk.toko_id='$toko_id'")->row_array()['total'];
    	$total_produk = $this->db->query("SELECT
    											COUNT(id) as total
    										FROM
    											$this->tabel_produk
    										WHERE
    											toko_id = '$toko_id'")->row_array()['total'];
    	$total_pesanan = $this->db->query("SELECT
    											COUNT($this->tabel_transaksi_detail.id) as total
    										FROM
    											$this->tabel_transaksi_detail
    										LEFT JOIN
    										    $this->tabel_transaksi
    										    ON $this->tabel_transaksi_detail.transaksi_id = $this->tabel_transaksi.id
    										WHERE
    											$this->tabel_transaksi_detail.toko_id = '$toko_id'
    										AND $this->tabel_transaksi.status = '1' ")->row_array()['total'];

    	$menunggu_diproses = $this->db->query("
										      SELECT 
										        COUNT($this->tabel_transaksi_detail.id) AS total
										      FROM
										        $this->tabel_transaksi_detail
										        LEFT JOIN $this->tabel_transaksi ON $this->tabel_transaksi.id = $this->tabel_transaksi_detail.transaksi_id
										      WHERE
										        $this->tabel_transaksi.status = '1' AND
										        $this->tabel_transaksi_detail.status = '1' AND
										        $this->tabel_transaksi_detail.toko_id = '$toko_id'
										    ")->row_array()['total'];

	    $diproses = $this->db->query("
								      SELECT 
								        COUNT($this->tabel_transaksi_detail.id) AS total
								      FROM
								        $this->tabel_transaksi_detail
								        LEFT JOIN $this->tabel_transaksi ON $this->tabel_transaksi.id = $this->tabel_transaksi_detail.transaksi_id
								      WHERE
								        $this->tabel_transaksi.status = '1' AND
								        $this->tabel_transaksi_detail.status = '2' AND
								        $this->tabel_transaksi_detail.toko_id = '$toko_id'
								    ")->row_array()['total'];

	    $dikirim = $this->db->query("
								      SELECT 
								        COUNT($this->tabel_transaksi_detail.id) AS total
								      FROM
								        $this->tabel_transaksi_detail
								        LEFT JOIN $this->tabel_transaksi ON $this->tabel_transaksi.id = $this->tabel_transaksi_detail.transaksi_id
								      WHERE
								        $this->tabel_transaksi.status = '1' AND
								        $this->tabel_transaksi_detail.status = '3' AND
								        $this->tabel_transaksi_detail.toko_id = '$toko_id'
								    ")->row_array()['total'];

	    $selesai = $this->db->query("
								      SELECT 
								        COUNT($this->tabel_transaksi_detail.id) AS total
								      FROM
								        $this->tabel_transaksi_detail
								        LEFT JOIN $this->tabel_transaksi ON $this->tabel_transaksi.id = $this->tabel_transaksi_detail.transaksi_id
								      WHERE
								        $this->tabel_transaksi.status = '1' AND
								        $this->tabel_transaksi_detail.status = '4' AND
								        $this->tabel_transaksi_detail.toko_id = '$toko_id'
								    ")->row_array()['total'];

	    $dibatalkan = $this->db->query("
									      SELECT 
									        COUNT($this->tabel_transaksi_detail.id) AS total
									      FROM
									        $this->tabel_transaksi_detail
									        LEFT JOIN $this->tabel_transaksi ON $this->tabel_transaksi.id = $this->tabel_transaksi_detail.transaksi_id
									      WHERE
									        $this->tabel_transaksi.status = '1' AND
									        $this->tabel_transaksi_detail.status = '0' AND
									        $this->tabel_transaksi_detail.toko_id = '$toko_id'
									    ")->row_array()['total'];
	    $result['Error'] = false;
	    $result['Message'] = null;
	    $result['Data'] = [
	    	'total_ulasan' => $total_ulasan,
	    	'total_komplain' => $total_komplain,
	    	'total_produk' => $total_produk,
	    	'total_pesanan' => $total_pesanan,
	    	'menunggu_diproses' => $menunggu_diproses,
	    	'diproses' => $diproses,
	    	'dikirim' => $dikirim,
	    	'selesai' => $selesai,
	    	'dibatalkan' => $dibatalkan
	    ];

	    output:
	    return $result;


    }

    function pesanan($params)
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
    									$this->tabel_toko.id
    								FROM
    									$this->tabel_toko
									LEFT JOIN
										$this->tabel_user
										ON $this->tabel_toko.user_id=$this->tabel_user.id
    								WHERE
    									$this->tabel_user.api_token = '$client_token'")->row_array();
    	if (!$user) {
    		$result['Error'] = true;
    		$result['Message'] = "Pengguna tidak ditemukan";
    		goto output;
    	}

    	$toko_id = $user['id'];

		$where = '';

		$where_status = "";

		switch ($status) {
			case 'all':
				break;
			case '1':
				$where_status .= "AND $this->tabel_transaksi_detail.status = '$status'";
				break;
			case '2':
				$where_status .= "AND $this->tabel_transaksi_detail.status = '$status'";
				break;
			case '3':
				$where_status .= "AND $this->tabel_transaksi_detail.status = '$status'";
				break;
			case '4':
				$where_status .= "AND $this->tabel_transaksi_detail.status = '$status'";
				break;
			case 'dibatalkan':
				$where_status .= "AND $this->tabel_transaksi_detail.status = '0'";
				break;
			
			default:
				break;
		}

		$jumlah_data = $this->db->query("
			SELECT
				$this->tabel_transaksi_detail.id,
				$this->tabel_transaksi_detail.transaksi_id,
				$this->tabel_transaksi_detail.toko_id,
				$this->tabel_toko.nama_toko AS toko_nama,
				$this->tabel_transaksi_detail.no_transaksi,
				$this->tabel_transaksi.created_at
			FROM
				$this->tabel_transaksi_detail
				LEFT JOIN $this->tabel_toko ON $this->tabel_toko.id = $this->tabel_transaksi_detail.toko_id
				LEFT JOIN $this->tabel_transaksi ON $this->tabel_transaksi_detail.transaksi_id = $this->tabel_transaksi.id
				LEFT JOIN $this->tabel_alamat ON $this->tabel_transaksi.alamat_id=$this->tabel_alamat.id
				LEFT JOIN $this->tabel_kecamatan ON $this->tabel_alamat.kecamatan_id=$this->tabel_kecamatan.id
				LEFT JOIN $this->tabel_kabupaten ON $this->tabel_alamat.kabupaten_id=$this->tabel_kabupaten.id
				LEFT JOIN $this->tabel_provinsi ON $this->tabel_alamat.provinsi_id=$this->tabel_provinsi.id
			WHERE
				$this->tabel_transaksi_detail.toko_id = '$toko_id'
				AND $this->tabel_transaksi.status = '1' 
				$where_status
				$where
				
		")->num_rows();

		if ($jumlah_data < 1) {
			$result['Error'] = true;
			$result['Message'] = "Belum ada pesanan";
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
										$this->tabel_transaksi.payment_metode,
										$this->tabel_transaksi.payment_output,
										$this->tabel_transaksi.no_invoice,
										$this->tabel_transaksi.status,
										$this->tabel_transaksi.total_bayar,
										$this->tabel_transaksi.ppn,
										$this->tabel_transaksi_detail.status as detail_status,
										$this->tabel_alamat.penerima_nama,
										$this->tabel_alamat.penerima_no_telepon,
										$this->tabel_alamat.alamat as alamat_penerima,
										$this->tabel_alamat.nama as alamat_penerima_nama,
										$this->tabel_kecamatan.nama as alamat_kecamatan_nama,
										$this->tabel_kabupaten.nama as alamat_kabupaten_nama,
										$this->tabel_provinsi.nama as alamat_provinsi_nama,
										$this->tabel_transaksi.created_at
									FROM
										$this->tabel_transaksi_detail
										LEFT JOIN $this->tabel_toko ON $this->tabel_toko.id = $this->tabel_transaksi_detail.toko_id
										LEFT JOIN $this->tabel_transaksi ON $this->tabel_transaksi_detail.transaksi_id = $this->tabel_transaksi.id
										LEFT JOIN $this->tabel_alamat ON $this->tabel_transaksi.alamat_id=$this->tabel_alamat.id
										LEFT JOIN $this->tabel_kecamatan ON $this->tabel_alamat.kecamatan_id=$this->tabel_kecamatan.id
										LEFT JOIN $this->tabel_kabupaten ON $this->tabel_alamat.kabupaten_id=$this->tabel_kabupaten.id
										LEFT JOIN $this->tabel_provinsi ON $this->tabel_alamat.provinsi_id=$this->tabel_provinsi.id
									WHERE
										$this->tabel_transaksi_detail.toko_id = '$toko_id' 
										AND $this->tabel_transaksi.status = '1' 
										$where_status
										$where
									ORDER BY
										$this->tabel_transaksi.id DESC
									LIMIT
										$pagination[Data_ke],$limit")->result_array();

		$result['Error'] = false;
		$result['Message'] = "success.";
		$result['Pagination'] = $pagination;
		$no = 0;
		$expire = [];
		$sattlement = [];
		$log = [];
		foreach ($pesanan as $key) {
			if ($key['status'] == 0 && $key['payment_metode'] == "midtrans") {
				$status_pesanan = "Belum dibayar";
				// $midtrans = $this->midtrans(array(
				// 	"url" => $key['no_invoice']."/status"
				// ));

				// if ($midtrans['transaction_status'] == "expire") {
				// 	$expire[$no] = array(
				// 		'status' => '2',
				// 		'no_invoice' => $key['no_invoice']
				// 	);
				// }else if ($midtrans['transaction_status'] == "settlement") {
				// 	$sattlement[$no] = array(
				// 		'status' => '1',
				// 		'no_invoice' => $key['no_invoice']
				// 	);

				// 	$log[$no] = array(
				// 		'expired_at' => date('Y-m-d H:i:s', strtotime("+".$this->get_maksimal_pengiriman()." days", strtotime(date('Y-m-d H:i:s')))),
				// 		'transaksi_id' => $key['id']
				// 	);
				// }
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

		output:
		return $result;
	 }
	 
	public function chart($params)
	{
		$client_token = $params['client_token'];

		if (empty($client_token)) {
			$hasil = array(
				'Error' => true,
				'Message' => "Anda belum login."
			);
			goto output;
		}

		$user = $this->db->query("SELECT
    									$this->tabel_toko.id
    								FROM
    									$this->tabel_toko
									LEFT JOIN
										$this->tabel_user
										ON $this->tabel_toko.user_id=$this->tabel_user.id
    								WHERE
    									$this->tabel_user.api_token = '$client_token'")->row_array();
    	if (!$user) {
    		$result['Error'] = true;
    		$result['Message'] = "Pengguna tidak ditemukan";
    		goto output;
    	}

    	$toko_id = $user['id'];

		$belum_dibayar = $this->db->query("
			SELECT
			COUNT($this->tabel_transaksi_detail.id) AS total,
			MONTH($this->tabel_transaksi.created_at) AS bulan
			FROM
			$this->tabel_transaksi
			LEFT JOIN $this->tabel_transaksi_detail ON $this->tabel_transaksi_detail.transaksi_id = $this->tabel_transaksi.id
			WHERE
			$this->tabel_transaksi.status = '0' AND
			$this->tabel_transaksi_detail.toko_id = '$toko_id'
			GROUP BY
			MONTH($this->tabel_transaksi.created_at)
		");

		$menunggu_diproses = $this->db->query("
			SELECT
			COUNT($this->tabel_transaksi_detail.id) AS total,
			MONTH($this->tabel_transaksi.log_dibayar) AS bulan
			FROM
			$this->tabel_transaksi
			LEFT JOIN $this->tabel_transaksi_detail ON $this->tabel_transaksi_detail.transaksi_id = $this->tabel_transaksi.id
			WHERE
			$this->tabel_transaksi.status = '1' AND
			$this->tabel_transaksi_detail.status = '1' AND
			$this->tabel_transaksi_detail.toko_id = '$toko_id'
			GROUP BY
			MONTH($this->tabel_transaksi.log_dibayar)
		");

		$diproses = $this->db->query("
			SELECT
			COUNT($this->tabel_transaksi_detail.id) AS total,
			MONTH($this->tabel_transaksi_detail.log_diproses) AS bulan
			FROM
			$this->tabel_transaksi
			LEFT JOIN $this->tabel_transaksi_detail ON $this->tabel_transaksi_detail.transaksi_id = $this->tabel_transaksi.id
			WHERE
			$this->tabel_transaksi.status = '1' AND
			$this->tabel_transaksi_detail.status = '2' AND
			$this->tabel_transaksi_detail.toko_id = '$toko_id'
			GROUP BY
			MONTH($this->tabel_transaksi_detail.log_diproses)
		");

		$dikirim = $this->db->query("
			SELECT
			COUNT($this->tabel_transaksi_detail.id) AS total,
			MONTH($this->tabel_transaksi_detail.log_dikirim) AS bulan
			FROM
			$this->tabel_transaksi
			LEFT JOIN $this->tabel_transaksi_detail ON $this->tabel_transaksi_detail.transaksi_id = $this->tabel_transaksi.id
			WHERE
			$this->tabel_transaksi.status = '1' AND
			$this->tabel_transaksi_detail.status = '3' AND
			$this->tabel_transaksi_detail.toko_id = '$toko_id'
			GROUP BY
			MONTH($this->tabel_transaksi_detail.log_dikirim)
		");

		$diterima = $this->db->query("
			SELECT
			COUNT($this->tabel_transaksi_detail.id) AS total,
			MONTH($this->tabel_transaksi_detail.log_diterima) AS bulan
			FROM
			$this->tabel_transaksi
			LEFT JOIN $this->tabel_transaksi_detail ON $this->tabel_transaksi_detail.transaksi_id = $this->tabel_transaksi.id
			WHERE
			$this->tabel_transaksi.status = '1' AND
			$this->tabel_transaksi_detail.status = '4' AND
			$this->tabel_transaksi_detail.toko_id = '$toko_id'
			GROUP BY
			MONTH($this->tabel_transaksi_detail.log_diterima)
		");

		$dibatalkan = $this->db->query("
			SELECT
			COUNT($this->tabel_transaksi_detail.id) AS total,
			MONTH($this->tabel_transaksi_detail.log_dibatalkan) AS bulan
			FROM
			$this->tabel_transaksi
			LEFT JOIN $this->tabel_transaksi_detail ON $this->tabel_transaksi_detail.transaksi_id = $this->tabel_transaksi.id
			WHERE
			-- $this->tabel_transaksi.status = '1' AND
			$this->tabel_transaksi_detail.status = '0' AND
			$this->tabel_transaksi_detail.toko_id = '$toko_id'
			GROUP BY
			MONTH($this->tabel_transaksi_detail.log_dibatalkan)
		");

		$penjualan_hari_ini = $this->db->query("
			SELECT
			SUM($this->tabel_transaksi_produk.harga * $this->tabel_transaksi_produk.qty) + SUM($this->tabel_transaksi_detail.kurir_value) AS total
			FROM
			$this->tabel_transaksi_detail
			LEFT JOIN $this->tabel_transaksi_produk ON $this->tabel_transaksi_produk.transaksi_id = $this->tabel_transaksi_detail.transaksi_id AND $this->tabel_transaksi_produk.toko_id = $this->tabel_transaksi_detail.toko_id
			WHERE
			DATE($this->tabel_transaksi_detail.log_diterima) = '".date('Y-m-d')."' AND
			$this->tabel_transaksi_detail.status = '4' AND
			$this->tabel_transaksi_detail.toko_id = '$toko_id'
			GROUP BY $this->tabel_transaksi_detail.id
		")->row_array()['total'];

		$penjualan_minggu_ini = $this->db->query("
			SELECT
			SUM($this->tabel_transaksi_produk.harga * $this->tabel_transaksi_produk.qty) + SUM($this->tabel_transaksi_detail.kurir_value) AS total
			FROM
			$this->tabel_transaksi_detail
			LEFT JOIN $this->tabel_transaksi_produk ON $this->tabel_transaksi_produk.transaksi_id = $this->tabel_transaksi_detail.transaksi_id AND $this->tabel_transaksi_produk.toko_id = $this->tabel_transaksi_detail.toko_id
			WHERE
			YEARWEEK($this->tabel_transaksi_detail.log_diterima) = YEARWEEK(NOW()) AND
			$this->tabel_transaksi_detail.status = '4' AND
			$this->tabel_transaksi_detail.toko_id = '$toko_id'
		")->row_array()['total'];

		$penjualan_bulan_ini = $this->db->query("
			SELECT
			SUM($this->tabel_transaksi_produk.harga * $this->tabel_transaksi_produk.qty) + SUM($this->tabel_transaksi_detail.kurir_value) AS total
			FROM
			$this->tabel_transaksi_detail
			LEFT JOIN $this->tabel_transaksi_produk ON $this->tabel_transaksi_produk.transaksi_id = $this->tabel_transaksi_detail.transaksi_id AND $this->tabel_transaksi_produk.toko_id = $this->tabel_transaksi_detail.toko_id
			WHERE
			YEAR($this->tabel_transaksi_detail.log_diterima) = '".date('Y')."' AND
			MONTH($this->tabel_transaksi_detail.log_diterima) = '".date('m')."' AND
			$this->tabel_transaksi_detail.status = '4' AND
			$this->tabel_transaksi_detail.toko_id = '$toko_id'
		")->row_array()['total'];

		$total_penjualan = $this->db->query("
			SELECT
			SUM($this->tabel_transaksi_produk.harga * $this->tabel_transaksi_produk.qty) + SUM($this->tabel_transaksi_detail.kurir_value) AS total
			FROM
			$this->tabel_transaksi_detail
			LEFT JOIN $this->tabel_transaksi_produk ON $this->tabel_transaksi_produk.transaksi_id = $this->tabel_transaksi_detail.transaksi_id AND $this->tabel_transaksi_produk.toko_id = $this->tabel_transaksi_detail.toko_id
			WHERE
			YEAR($this->tabel_transaksi_detail.log_diterima) = YEAR(NOW()) AND
			$this->tabel_transaksi_detail.status = '4' AND
			$this->tabel_transaksi_detail.toko_id = '$toko_id'
		")->row_array()['total'];

		$hasil['Error'] = false;
		$hasil['Message'] = "success.";
		$hasil['Data']['label'] = array(
			'Januari',
			'Februari',
			'Maret',
			'April',
			'Mei',
			'Juni',
			'Juli',
			'Agustus',
			'September',
			'Oktober',
			'November',
			'Desember'
		);

		$hasil['Data']['belum_dibayar'] = [];
		$hasil['Data']['menunggu_diproses'] = [];
		$hasil['Data']['diproses'] = [];
		$hasil['Data']['dikirim'] = [];
		$hasil['Data']['diterima'] = [];
		$hasil['Data']['dibatalkan'] = [];

		$hasil['Data']['statistik'] = array(
			'penjualan_hari_ini' => ($penjualan_hari_ini == null) ? "Rp. 0" : $this->uang->convert($penjualan_hari_ini),
			'penjualan_minggu_ini' => ($penjualan_minggu_ini == null) ? "Rp. 0" : $this->uang->convert($penjualan_minggu_ini),
			'penjualan_bulan_ini' => ($penjualan_bulan_ini == null) ? "Rp. 0" : $this->uang->convert($penjualan_bulan_ini),
			'total_penjualan' => ($total_penjualan == null) ? "Rp. 0" : $this->uang->convert($total_penjualan)
		);

		for ($i=0; $i < 12; $i++) { 
			$total = intval(0);
			foreach ($belum_dibayar->result_array() as $key) {
			if (($i + 1) == $key['bulan']) {
				$total = intval($key['total']);
			}
			}
			$hasil['Data']['belum_dibayar'][$i] = array(
			'total' => $total,
			'bulan' => $i+1
			);
		}

		for ($i=0; $i < 12; $i++) { 
			$total = intval(0);
			foreach ($menunggu_diproses->result_array() as $key) {
			if (($i + 1) == $key['bulan']) {
				$total = intval($key['total']);
			}
			}
			$hasil['Data']['menunggu_diproses'][$i] = array(
			'total' => $total,
			'bulan' => $i+1
			);
		}

		for ($i=0; $i < 12; $i++) { 
			$total = intval(0);
			foreach ($diproses->result_array() as $key) {
			if (($i + 1) == $key['bulan']) {
				$total = intval($key['total']);
			}
			}
			$hasil['Data']['diproses'][$i] = array(
			'total' => $total,
			'bulan' => $i+1
			);
		}

		for ($i=0; $i < 12; $i++) { 
			$total = intval(0);
			foreach ($dikirim->result_array() as $key) {
			if (($i + 1) == $key['bulan']) {
				$total = intval($key['total']);
			}
			}
			$hasil['Data']['dikirim'][$i] = array(
			'total' => $total,
			'bulan' => $i+1
			);
		}

		for ($i=0; $i < 12; $i++) { 
			$total = intval(0);
			foreach ($diterima->result_array() as $key) {
			if (($i + 1) == $key['bulan']) {
				$total = intval($key['total']);
			}
			}
			$hasil['Data']['diterima'][$i] = array(
			'total' => $total,
			'bulan' => $i+1
			);
		}

		for ($i=0; $i < 12; $i++) { 
			$total = intval(0);
			foreach ($dibatalkan->result_array() as $key) {
			if (($i + 1) == $key['bulan']) {
				$total = intval($key['total']);
			}
			}
			$hasil['Data']['dibatalkan'][$i] = array(
			'total' => $total,
			'bulan' => $i+1
			);
		}

		output:
		return $hasil;
	}
}