<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_Transaksi_refund extends MY_Model {

	protected $tabel = 'mst_transaksi_refund';

	protected $tabel_detail = 'mst_transaksi_detail';

	protected $tabel_detail_produk = 'mst_transaksi_produk';

	protected $tabel_user = 'mst_user';

	public function __construct()
	{
		parent::__construct();
	}

	private function total_pesanan($params)
	{
		$transaksi_id = $params['transaksi_id'];
		$no_transaksi = $params['no_transaksi'];

		$get_detail = $this->db->query("
			SELECT
				$this->tabel_detail.toko_id,
				$this->tabel_detail.kurir_value
			FROM
				$this->tabel_detail
			WHERE
				$this->tabel_detail.no_transaksi = '$no_transaksi' AND
				$this->tabel_detail.transaksi_id = '$transaksi_id'
		")->row_array();

		$toko_id = $get_detail['toko_id'];
		$kurir_value = $get_detail['kurir_value'];

		$get_produk = $this->db->query("
			SELECT
				SUM($this->tabel_detail_produk.harga * $this->tabel_detail_produk.qty) AS total
			FROM
				$this->tabel_detail_produk
			WHERE
				toko_id = '$toko_id' AND
				transaksi_id = '$transaksi_id'
		")->row_array();

		$sub_total = $get_produk['total'];

		return $kurir_value + $sub_total;
	}

	public function index($params)
	{
		$start = $params['start'];
		$length = $params['length'];
		$draw = $params['draw'];
		$search = $params['search']['value'];
		$status = $params['status'];

		$limit = ($start != "" && !empty($length)) ? "LIMIT $start, $length":"";
		$where = "WHERE $this->tabel_user.nama LIKE '%$search%'";
		($status != "") ? $where .= " AND $this->tabel.status = '$status'":"";

		$get_transaksi = $this->db->query("
			SELECT
				$this->tabel.id,
				$this->tabel.transaksi_id,
				$this->tabel.no_transaksi,
				$this->tabel.user_id,
				$this->tabel_user.nama AS user_nama,
				$this->tabel.status,
				$this->tabel.created_at,
				$this->tabel.updated_at
			FROM
				$this->tabel
				LEFT JOIN $this->tabel_user ON $this->tabel_user.id = $this->tabel.user_id
			$where
			$limit
		")->result_array();
		$no = 0;
		$hasil['Error'] = false;
		$hasil['Message'] = "success.";
		$hasil['Data'] = array();
		foreach ($get_transaksi as $key) {
			if ($key['status'] == 0) {
				$status = "Belum ditransfer";
			}else{
				$status = "Ditransfer";
			}
			$hasil['Data'][$no++] = array(
				'id' => $key['id'],
				'transaksi_id' => $key['transaksi_id'],
				'total' => $this->total_pesanan(array(
					'no_transaksi' => $key['no_transaksi'],
					'transaksi_id' => $key['transaksi_id']
				)),
				'no_transaksi' => $key['no_transaksi'],
				'user_id' => $key['user_id'],
				'user_nama' => $key['user_nama'],
				'status' => $status,
				'created_at' => $key['created_at'],
				'updated_at' => $key['updated_at']
			);
		}
		$hasil['recordsFiltered'] = $this->recordsFiltered("$this->tabel LEFT JOIN $this->tabel_user ON $this->tabel_user.id = $this->tabel.user_id", "$this->tabel.id", "$this->tabel_user.nama LIKE '%$search%'");
		$hasil['recordsTotal'] = $this->recordsTotal("$this->tabel");
		$hasil['draw'] = $draw;
		goto output;

		output:
		return $hasil;
	}

	public function transfer($params)
	{
		$transaksi_id = $params['transaksi_id'];
		$no_transaksi = $params['no_transaksi'];

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
		}else{
			$cek_transaksi = $this->db->query("
				SELECT
					id
				FROM
					$this->tabel
				WHERE
					no_transaksi = '$no_transaksi' AND
					transaksi_id = '$transaksi_id'
			");

			if ($cek_transaksi->num_rows() == 0) {
				$hasil = array(
					'Error' => true,
					'Message' => "Pesanan tidak ditemukan."
				);
				goto output;
			}

			$this->db->update($this->tabel, array(
				'status' => '1'
			), array(
				'no_transaksi' => $no_transaksi,
				'transaksi_id' => $transaksi_id
			));

			$hasil = array(
				'Error' => false,
				'Message' => "Pesanan berhasil ditransfer."
			);
			goto output;
		}

		output:
		return $hasil;
	}

}

/* End of file M_Transaksi_refund.php */
/* Location: ./application/models/M_Transaksi_refund.php */