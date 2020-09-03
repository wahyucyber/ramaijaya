<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_Transaksi_pengajuan extends MY_Model {

	protected $tabel_transaksi = 'mst_transaksi';

	protected $tabel_transaksi_pengajuan_pencairan = 'mst_transaksi_pengajuan_pencairan';

	protected $tabel_transaksi_detail = 'mst_transaksi_detail';

	protected $tabel_transaksi_produk = 'mst_transaksi_produk';

	protected $tabel_mst_toko = 'mst_toko';

	public function __construct()
	{
		parent::__construct();
	}

	private function get_total_transaksi($toko_id, $transaksi_id, $no_transaksi)
	{
		$get_detail = $this->db->query("
			SELECT
				$this->tabel_transaksi_detail.kurir_value
			FROM
				$this->tabel_transaksi_detail
			WHERE
				$this->tabel_transaksi_detail.toko_id = '$toko_id' AND
				$this->tabel_transaksi_detail.no_transaksi = '$no_transaksi' AND
				$this->tabel_transaksi_detail.transaksi_id = '$transaksi_id'
		")->row_array();

		$ongkir = $get_detail['kurir_value'];

		$get_produk = $this->db->query("
			SELECT
				SUM($this->tabel_transaksi_produk.harga * $this->tabel_transaksi_produk.qty) AS total
			FROM
				$this->tabel_transaksi_produk
			WHERE
				$this->tabel_transaksi_produk.toko_id = '$toko_id' AND
				$this->tabel_transaksi_produk.transaksi_id = '$transaksi_id'
		")->row_array();

		$sub_total = $get_produk['total'];

		return $ongkir + $sub_total;
	}

	public function index($params)
	{
		$start = $params['start'];
		$length = $params['length'];
		$draw = $params['draw'];
		$search = $params['search']['value'];
		$status = $params['status'];

		$where = "WHERE $this->tabel_transaksi_pengajuan_pencairan.no_transaksi LIKE '%$search%'";
		($status != "") ? $where .= " AND $this->tabel_transaksi_pengajuan_pencairan.status = '$status'":"";

		$get_transaksi = $this->db->query("
			SELECT
				$this->tabel_transaksi_pengajuan_pencairan.transaksi_id,
				$this->tabel_transaksi_pengajuan_pencairan.no_transaksi,
				$this->tabel_transaksi_pengajuan_pencairan.toko_id,
				$this->tabel_mst_toko.nama_toko,
				$this->tabel_mst_toko.bank_nama,
				$this->tabel_mst_toko.bank_atasnama,
				$this->tabel_mst_toko.bank_rekening,
				$this->tabel_transaksi_pengajuan_pencairan.status,
				$this->tabel_transaksi_pengajuan_pencairan.created_at,
				$this->tabel_transaksi_pengajuan_pencairan.updated_at
			FROM
				$this->tabel_transaksi_pengajuan_pencairan
				LEFT JOIN $this->tabel_mst_toko ON $this->tabel_mst_toko.id = $this->tabel_transaksi_pengajuan_pencairan.toko_id
				$where
		")->result_array();
		$hasil['Error'] = false;
		$hasil['Message'] = "success.";
		$hasil['Data'] = array();
		$no = 0;
		foreach ($get_transaksi as $key) {
			if ($key['status'] == 0) {
				$status = "Belum ditransfer";
			}else{
				$status = "Ditransfer";
			}

			$hasil['Data'][$no++] = array(
				'transaksi_id' => $key['transaksi_id'],
				'no_transaksi' => $key['no_transaksi'],
				'status' => $status,
				'total' => $this->get_total_transaksi($key['toko_id'], $key['transaksi_id'], $key['no_transaksi']),
				'toko_id' => $key['toko_id'],
				'toko_nama' => $key['nama_toko'],
				'toko_bank' => $key['bank_nama'],
				'toko_bank_atasnama' => $key['bank_atasnama'],
				'toko_rekening' => $key['bank_rekening'],
				'created_at' => $key['created_at'],
				'updated_at' => $key['updated_at']
			);
		}
		$hasil['recordsTotal'] = $this->recordsTotal($this->tabel_transaksi_pengajuan_pencairan);
		$hasil['recordsFiltered'] = $this->recordsFiltered($this->tabel_transaksi_pengajuan_pencairan, "$this->tabel_transaksi_pengajuan_pencairan.id", "$this->tabel_transaksi_pengajuan_pencairan.no_transaksi LIKE '%$search%'");
		$hasil['draw'] = $draw;
		goto output;

		output:
		return $hasil;
	}

	public function transfer($params)
	{
		$transaksi_id = $params['transaksi_id'];
		$no_transaksi = $params['no_transaksi'];
		$toko_id = $params['toko_id'];

		if (empty($transaksi_id)) {
			$hasil = array(
				'Error' => true,
				'Message' => "Parameter 'transaksi_id' tidak diset."
			);
			goto output;
		}else if (empty($no_transaksi)) {
			$hasil = array(
				'Error' => true,
				'Message' => "Parameter 'no_transaksi' tidak diset."
			);
			goto output;
		}else if (empty($toko_id)) {
			$hasil = array(
				'Error' => true,
				'Message' => "Parameter 'toko_id' tidak diset."
			);
			goto output;
		}else{
			$cek_transaksi = $this->db->query("
				SELECT
					id
				FROM
					$this->tabel_transaksi
				WHERE
					id = '$transaksi_id'
			")->num_rows();

			if ($cek_transaksi == 0) {
				$hasil = array(
					'Error' => true,
					'Message' => "Transaksi tidak ditemukan."
				);
				goto output;
			}

			$cek_pesanan = $this->db->query("
				SELECT
					id
				FROM
					$this->tabel_transaksi_detail
				WHERE
					no_transaksi = '$no_transaksi' AND
					toko_id = '$toko_id' AND
					transaksi_id = '$transaksi_id'
			")->num_rows();

			if ($cek_pesanan == 0) {
				$hasil = array(
					'Error' => true,
					'Message' => "Pesanan tidak ditemukan."
				);
				goto output;
			}

			$this->db->update($this->tabel_transaksi_pengajuan_pencairan, array(
				'status' => '1'
			), array(
				'transaksi_id' => $transaksi_id,
				'no_transaksi' => $no_transaksi,
				'toko_id' => $toko_id
			));

			$hasil = array(
				'Error' => false,
				'Message' => "Transaksi berhasil dicairkan."
			);
			goto output;
		}

		output:
		return $hasil;
	}

}

/* End of file M_Transaksi_pengajuan.php */
/* Location: ./application/models/M_Transaksi_pengajuan.php */